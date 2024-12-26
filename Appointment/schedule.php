<?php 
    require_once "./PDO_Appointment.php";    
    require_once "./Method.php";    
    session_start();

    var_dump($_SESSION);
    $doctors = [];
    $errors = [];

    if($_SERVER['REQUEST_METHOD'] === 'GET')
        $doctors = GetAllDoctors();
    
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        if($_POST['speciality'] == "None"){
            $doctors = GetAllDoctors();
        }
        else if($_POST['speciality'] != null) {
            $doctors = GetAllDoctorsBy($_POST['speciality']);
        }

        if(isset($_POST['schedule_appointment'])) {
            HandleScheduleAppointment($_POST, $errors);
        }
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Doctor</title>
    <link rel="stylesheet" href="../CSS/appointment.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="nav-container">
        <nav class="appointment-nav">
            <ul>
                <li><a href="schedule.php" class="nav-link">Schedule Appointment</a></li>
                <li><a href="MyAppointments.php" class="nav-link active">My Appointments</a></li>
            </ul>
        </nav>
    </div>

    <div class="container">
        <h1>Find Your Doctor</h1>
            <!-- Doctor Search Section -->
            <div class="search-section">
                <form action="schedule.php" method="POST">
                    <div class="form-group">
                        <label for="specialty">specialty:</label>
                        <select id="speciality" name="speciality">
                        <option value="None">None</option>
                        <?php
                            $Selected_specialty = isset($_POST['speciality']) ? $_POST['speciality'] : '';
                            
                            $specialties = getAllspatiality(); 
                                                                                    
                            foreach($specialties as $specialty) {
                                $selected = ($Selected_specialty === $specialty['spatiality']) ? 'selected' : '';
                                echo "<option name='speciality' value='{$specialty["spatiality"]}' {$selected}> {$specialty['spatiality']} </option>";
                            }
                        ?>
                        </select>
                        <button type="submit" name="search" class="btn-search">Search</button>
                    </div>
                </form>
            </div>
        <!-- Doctor Information Card -->
        <h4>Doctor Information</h4>
        <form action="schedule.php" method="POST">
            <?php
                foreach($doctors as $doctor) {
                    ?>
            <div class="doctor-info-card">
                <input type="radio" name="doctor_select" value="<?php echo $doctor['doc_no']; ?>" class="radio-btn">
                <div class="info-item">
                    <span class="info-label">Name</span>
                    <span class="info-value">Dr. <?php echo $doctor['name']; ?></span>
                </div>
                
                <div class="info-item">
                    <span class="info-label">Speciality</span>
                    <span class="info-value"><?php echo $doctor['spatiality']; ?></span>
                </div>
                
                <div class="info-item min-size">
                    <span class="info-label">Experience</span>
                    <span class="info-value"><?php echo $doctor['expr_years']; ?> Years</span>
                </div>
                
                <div class="info-item">
                    <span class="info-label">Email</span>
                    <span class="info-value"><?php echo $doctor['email']; ?></span>
                </div>
                
                <div class="info-item">
                    <span class="info-label">nationality</span>
                    <span class="info-value"><?php echo $doctor['nationality']; ?></span>
                </div>

                <div class="info-item min-size">
                    <span class="info-label">Gender</span>
                    <span class="info-value"><?php echo $doctor['gender']; ?></span>
                </div>
                
                <div class="info-item">
                    <span class="info-label">Available Days</span>
                    <span class="info-value"><?php echo $doctor['day_work']; ?></span>
                </div>
            </div>
            <?php
            }
            ?>        
            <!-- Appointment Form -->
            <div class="appointment-form">
            <h2 style="margin-top: 30px;">Schedule Appointment</h2>
                <input type="hidden" name="doc_no" value="<?php echo isset($doctor['doctor_select']) ? $doctor['doctor_select'] : ""; ?>" id="doc_no">
                <input type="hidden" name="speciality" value="<?php echo isset($_POST['speciality']) ? $_POST['speciality'] : 'None'; ?>">           
                
                <div class="form-group">
                    <label for="appointmentDate">Select Preferred Date:</label>
                    <input type="date" id="appointmentDate" name="appointmentDate" required value="<?php echo isset($_POST['appointmentDate']) ? $_POST['appointmentDate'] : ''; ?>">
                </div>
                <div class="button-group">
                    <button type="submit" name="schedule_appointment" class="btn-submit">Schedule Appointment</button>
                    <a href="../index.PHP" class="btn-submit">Back to Home</a>
                    <span><?php if(isset($errors['schedule_appointment'])) echo "<span class='error'>". $errors['schedule_appointment'] ."</span>" ?> </span>
                    <span><?php if(isset($errors['schedule_appointment_success'])) echo "<span class='success'>". $errors['schedule_appointment_success'] ."</span>" ?> </span>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
