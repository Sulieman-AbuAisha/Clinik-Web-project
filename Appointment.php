<?php
include 'PDO/PDO.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make an Appointment</title>
    <link rel="stylesheet" href="CSS/Appointment.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="appointment-container">
        <h2>Book an Appointment</h2>
        <form action="process_appointment.php" method="POST" id="appointmentForm">
            <!-- Patient Information -->
            <div class="form-section">
                <h3>Patient Information</h3>
                <div class="form-group">
                    <label for="name">Full Name:</label>
                    <input type="text" id="name" name="name" required>
                    <label for="gender">Gender:</label>
                    <select id="gender" name="gender" required>
                        <option value="">Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="nationality">Nationality:</label>
                    <input type="text" id="nationality" name="nationality" required >
                </div>

                <div class="form-group">
                    <label for="tel">Phone Number:</label>
                    <input type="tel" id="tel" name="tel" required placeholder="e.g., +1-234-567-8900">
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required >
                </div>
            </div>
            <!-- Appointment Details -->
            <div class="form-section">
                <h3>Appointment Details</h3>
                <div class="form-group">
                    <label for="doctor">Select Doctor:</label>
                    <select id="doctor" name="d_no" required>
                        <option value="">Select Doctor</option>
                        <?php 
                        $doctors = getDoctors($pdo);
                                if ($doctors) {
                                    foreach($doctors as $doctor) {
                                        echo "<option value='" . htmlspecialchars($doctor['id']) . "'>" 
                                            . htmlspecialchars($doctor['name']) 
                                            . "</option>";
                                    }
                                } else {
                                    echo "<option value=''>Error loading doctors. Please try again later.</option>";
                                }
                                ?>
                    </select>
                </div>

                <div id="doctorDetails" class="doctor-details" style="display: none;">
                    <div class="doctor-info-card">
                        <h4>Doctor Details</h4>
                        <div id="doctorDetailsContent">
                            <div class="doctor-info-grid">
                                <div class="info-item">
                                    <span class="info-label">Education:</span>
                                    <span class="info-value" id="doctorEducation"></span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Languages:</span>
                                    <span class="info-value" id="doctorLanguages"></span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Consultation Fee:</span>
                                    <span class="info-value" id="doctorFee"></span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Available Hours:</span>
                                    <span class="info-value" id="doctorHours"></span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Working Days:</span>
                                    <span class="info-value" id="doctorDays"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="date">Appointment Date:</label>
                    <input type="date" id="date" name="date" required 
                           min="<?php echo date('Y-m-d'); ?>">
                </div>

                <div class="form-group">
                    <label for="type">Appointment Type:</label>
                    <select id="type" name="type" required>
                        <option value="">Select Type</option>
                        <option value="consultation">Consultation</option>
                        <option value="follow-up">Follow-up</option>
                        <option value="emergency">Emergency</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="submit-btn">
                <i class="fas fa-calendar-check"></i> Book Appointment
            </button>
        </form>
    </div>
</body>
</html>
