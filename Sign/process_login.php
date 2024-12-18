<?php
session_start();
include 'PDO/PDO.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Add your login validation logic here
    // If successful:
    $_SESSION['patient_id'] = $user_id; // Set from database
    $_SESSION['patient_name'] = $name; // Set from database
    header('Location: make_appointment.php');
}
?>
