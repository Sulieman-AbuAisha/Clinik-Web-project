<?php
require_once "./PDO_Admin";
// session_start();

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   if (isset($_POST['action'])) {
       switch ($_POST['action']) {
           case 'add':
               if (addDoctor($_POST)) {
                   $_SESSION['message'] = "Doctor added successfully";
               }
               break;
           case 'update':
               if (updateDoctor($_POST)) {
                   $_SESSION['message'] = "Doctor updated successfully";
               }
               break;
           case 'delete':
               if (deleteDoctor($_POST['doc_no'])) {
                   $_SESSION['message'] = "Doctor deleted successfully";
               }
               break;
       }
   }
   exit();
}
$doctors = getAllDoctors();
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Manage Doctors</title>
   <link rel="stylesheet" href="../CSS/Admin.css">
</head>
<body>
   <div class="container">
       <h1>Manage Doctors</h1>
       
       <?php if (isset($_SESSION['message'])): ?>
           <div class="message"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
       <?php endif; ?>
        <!-- Add Doctor Form -->
       <div class="form-section">
           <h2>Add New Doctor</h2>
           <form method="POST" class="doctor-form">
               <input type="hidden" name="action" value="add">
               <input type="text" name="name" placeholder="Doctor Name" required>
               <input type="text" name="spatiality" placeholder="Speciality" required>
               <input type="number" name="expr_years" placeholder="Years of Experience" required>
               <select name="gender" required>
                   <option value="">Select Gender</option>
                   <option value="M">Male</option>
                   <option value="F">Female</option>
               </select>
               <input type="text" name="nationality" placeholder="Nationality" required>
               <input type="email" name="email" placeholder="Email" required>
               <div class="days-selection">
                   <label>Working Days:</label>
                   <div class="checkbox-group">
                       <label><input type="checkbox" name="day_work[]" value="Sunday">Sunday</label>
                       <label><input type="checkbox" name="day_work[]" value="Monday">Monday</label>
                       <label><input type="checkbox" name="day_work[]" value="Tuesday">Tuesday</label>
                       <label><input type="checkbox" name="day_work[]" value="Wednesday">Wednesday</label>
                       <label><input type="checkbox" name="day_work[]" value="Thursday">Thursday</label>
                       <label><input type="checkbox" name="day_work[]" value="Friday">Friday</label>
                       <label><input type="checkbox" name="day_work[]" value="Saturday">Saturday</label>
                   </div>
               </div>
               <button type="submit">Add Doctor</button>
           </form>
       </div>
        <!-- Doctors List -->
       <div class="doctors-list">
           <h2>Current Doctors</h2>
           <table>
               <thead>
                   <tr>
                       <th>ID</th>
                       <th>Name</th>
                       <th>Speciality</th>
                       <th>Experience</th>
                       <th>Gender</th>
                       <th>Nationality</th>
                       <th>Email</th>
                       <th>Working Days</th>
                       <th>Actions</th>
                   </tr>
               </thead>
               <tbody>
                   <?php foreach ($doctors as $doctor): ?>
                       <tr>
                           <td><?php echo htmlspecialchars($doctor['doc_no']); ?></td>
                           <td><?php echo htmlspecialchars($doctor['name']); ?></td>
                           <td><?php echo htmlspecialchars($doctor['spatiality']); ?></td>
                           <td><?php echo htmlspecialchars($doctor['expr_years']); ?></td>
                           <td><?php echo htmlspecialchars($doctor['gender']); ?></td>
                           <td><?php echo htmlspecialchars($doctor['nationality']); ?></td>
                           <td><?php echo htmlspecialchars($doctor['email']); ?></td>
                           <td><?php echo htmlspecialchars($doctor['day_work']); ?></td>
                           <td>
                               <button onclick="editDoctor(<?php echo htmlspecialchars(json_encode($doctor)); ?>)">Edit</button>
                               <form method="POST" style="display: inline;">
                                   <input type="hidden" name="action" value="delete">
                                   <input type="hidden" name="doc_no" value="<?php echo $doctor['doc_no']; ?>">
                                   <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                               </form>
                           </td>
                       </tr>
                   <?php endforeach; ?>
               </tbody>
           </table>
       </div>
   </div>
    <script>
       function editDoctor(doctor) {
           // Populate form with doctor data for editing
           const form = document.querySelector('.doctor-form');
           form.querySelector('[name="action"]').value = 'update';
           form.innerHTML += `<input type="hidden" name="doc_no" value="${doctor.doc_no}">`;
           form.querySelector('[name="name"]').value = doctor.name;
           form.querySelector('[name="spatiality"]').value = doctor.spatiality;
           form.querySelector('[name="expr_years"]').value = doctor.expr_years;
           form.querySelector('[name="gender"]').value = doctor.gender;
           form.querySelector('[name="nationality"]').value = doctor.nationality;
           form.querySelector('[name="email"]').value = doctor.email;
           
           // Check working days
           const days = doctor.day_work.split(',');
           const checkboxes = form.querySelectorAll('[name="day_work[]"]');
           checkboxes.forEach(cb => {
               cb.checked = days.includes(cb.value);
           });
           
           // Change button text
           form.querySelector('button').textContent = 'Update Doctor';
           
           // Scroll to form
           form.scrollIntoView({ behavior: 'smooth' });
       }
   </script>
</body>
</html>