<?php
session_start();
require_once('./PDO_Appointment.php');

// Ensure user is logged in
if ($_SESSION['user']===false) {
    header('Location: ../Sign/Sign.php');
    exit();
} 

$user_id = $_SESSION['user']['u_No'];
$appointments = getPatientAppointments($user_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Appointments</title>
    <link rel="stylesheet" href="../CSS/appointment.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="nav-container">
        <nav class="appointment-nav">
            <ul>
                <li><a href="schedule.php" class="nav-link">Schedule Appointment</a></li>
                <li><a href="myappointments.php" class="nav-link active">My Appointments</a></li>
            </ul>
        </nav>
    </div>

    <div class="container">
        <h1>My Appointments</h1>
        <div class="appointments-list">
            <?php if (empty($appointments)): ?>
                <p class="no-appointments">You have no scheduled appointments.</p>
            <?php else: ?>
                <?php foreach ($appointments as $appointment): ?>
                    <div class="appointment-card">
                        <div class="appointment-info">
                            <h3>Doctor: Dr. <?php echo htmlspecialchars($appointment['name']); ?></h3>
                            <p>Date: <?php echo htmlspecialchars($appointment['Date']); ?></p>
                            <p>Status: <?php echo htmlspecialchars($appointment['Type']); ?></p>
                        </div>
                        <?php if ($appointment['Type'] === 'Pending'): ?>
                            <div class="appointment-actions">
                                <form action="cancel_appointment.php" method="POST">
                                    <input type="hidden" name="appointment_id" value="<?php echo $appointment['r_no']; ?>">
                                    <button type="submit" class="cancel-btn">Cancel Appointment</button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php if (isset($_SESSION['message'])): ?>
                        <div class="alert alert-success">
                            <?php 
                            echo $_SESSION['message']; 
                            unset($_SESSION['message']);
                            ?>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger">
                            <?php 
                            echo $_SESSION['error']; 
                            unset($_SESSION['error']);
                            ?>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>