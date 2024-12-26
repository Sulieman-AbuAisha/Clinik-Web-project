<?php
session_start();
require_once('./PDO_Appointment.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['appointment_id'])) {
    $appointment_id = $_POST['appointment_id'];
    $user_id = $_SESSION['user']['u_No'];
    
    cancelAppointment($appointment_id, $user_id);
}
header('Location: MyAppointments.php');
exit();
