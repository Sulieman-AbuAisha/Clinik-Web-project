<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/doctor_form.css">
</head>
<body>
    <div class="container form-container">
        <h2 class="mb-4"><?php echo isset($doctor) ? 'Edit Doctor' : 'Add New Doctor'; ?></h2>
        
        <form method="POST" action="doctor_actions.php">
            <input type="hidden" name="action" value="<?php echo isset($doctor) ? 'edit' : 'add'; ?>">
            <?php if(isset($doctor)): ?>
                <input type="hidden" name="doc_id" value="<?php echo $doctor['doc_no']; ?>">
                <input type="hidden" name="update" value="1">
            <?php endif; ?>

            <div class="form-group">
                <label for="name">Full Name:</label>
                <input type="text" class="form-control" id="name" name="name" 
                       value="<?php echo isset($doctor) ? $doctor['name'] : ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="specialty">Specialty:</label>
                <input type="text" class="form-control" id="specialty" name="specialty" 
                       value="<?php echo isset($doctor) ? $doctor['spatiality'] : ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="experience">Years of Experience:</label>
                <input type="number" class="form-control" id="experience" name="experience" 
                       value="<?php echo isset($doctor) ? $doctor['expr_years'] : ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="gender">Gender:</label>
                <select class="form-control" id="gender" name="gender" required>
                    <option value="">Select Gender</option>
                    <option value="Male" <?php echo (isset($doctor) && $doctor['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                    <option value="Female" <?php echo (isset($doctor) && $doctor['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                </select>
            </div>

            <div class="form-group">
                <label for="nationality">Nationality:</label>
                <input type="text" class="form-control" id="nationality" name="nationality" 
                       value="<?php echo isset($doctor) ? $doctor['nationality'] : ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" 
                       value="<?php echo isset($doctor) ? $doctor['email'] : ''; ?>" required>
            </div>

            <div class="form-group">
                <label>Working Days:</label><br>
                <?php
                $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                $selected_days = isset($doctor['day_work']) ? explode(',', $doctor['day_work']) : [];
                
                foreach ($days as $day) {
                    $checked = in_array($day, $selected_days) ? 'checked' : '';
                    echo "<label class='checkbox-inline'>
                            <input type='checkbox' name='working_days[]' value='$day' $checked> $day
                          </label>";
                }
                ?>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <?php echo isset($doctor) ? 'Update Doctor' : 'Add Doctor'; ?>
                </button>
                <a href="admin.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="js/doctor-validation.js"></script>
</body>
</html> 