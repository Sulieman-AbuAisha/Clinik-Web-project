<?php
require_once '../PDO/PDO.php';
session_start();

// Check admin privileges
if (!IsAdmin()) {
    header("Location: ../Sign/Sign.php");
    exit();
}

// Handle all doctor-related actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    switch ($action) {
        case 'add':
            if (isset($_POST['name'], $_POST['specialty'], $_POST['experience'])) {
                // Convert working days array to comma-separated string
                $working_days = isset($_POST['working_days']) ? implode(',', $_POST['working_days']) : '';
                
                $sql = "INSERT INTO doctor_info (name, spatiality, expr_years, gender, nationality, email, day_work) 
                        VALUES (:name, :specialty, :experience, :gender, :nationality, :email, :working_days)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    'name' => $_POST['name'],
                    'specialty' => $_POST['specialty'],
                    'experience' => $_POST['experience'],
                    'gender' => $_POST['gender'],
                    'nationality' => $_POST['nationality'],
                    'email' => $_POST['email'],
                    'working_days' => $working_days
                ]);
                $_SESSION['message'] = "Doctor added successfully!";
            }
            else{
                include 'doctor_form.php';
                exit();
            }
            break;

        case 'edit':
            if (isset($_POST['doc_id'])) {
                if (isset($_POST['update'])) {
                    // Convert working days array to comma-separated string
                    $working_days = isset($_POST['working_days']) ? implode(',', $_POST['working_days']) : '';
                    
                    $sql = "UPDATE doctor_info SET 
                            name = :name,
                            spatiality = :specialty,
                            expr_years = :experience,
                            gender = :gender,
                            nationality = :nationality,
                            email = :email,
                            day_work = :working_days
                            WHERE doc_no = :id";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([
                        'id' => $_POST['doc_id'],
                        'name' => $_POST['name'],
                        'specialty' => $_POST['specialty'],
                        'experience' => $_POST['experience'],
                        'gender' => $_POST['gender'],
                        'nationality' => $_POST['nationality'],
                        'email' => $_POST['email'],
                        'working_days' => $working_days
                    ]);
                    $_SESSION['message'] = "Doctor updated successfully!";
                } else {
                    // Show edit form
                    $doctor = getDoctorById($pdo, $_POST['doc_id']);
                    include 'doctor_form.php';
                    exit();
                }
            }
            break;

        case 'delete':
            if (isset($_POST['doc_id'])) {
                // Delete doctor
                $sql = "DELETE FROM doctor_info WHERE doc_no = :id";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['id' => $_POST['doc_id']]);
                $_SESSION['message'] = "Doctor deleted successfully!";
            }
            break;
    }
    
    // Redirect back to admin page
    header("Location: admin.php");
    exit();
}

function getDoctorById($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM doctor_info WHERE doc_no = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}