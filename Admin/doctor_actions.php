<?php
require_once '../PDO/PDO.php';
session_start();

function getDoctorById($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM doctor_info WHERE doc_no = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
function Add_Doctor($pdo, $PostData) 
{
    if (isset($PostData['add'])) 
    {
        $working_days = isset($PostData['working_days']) ? implode(',', $PostData['working_days']) : '';
        $sql = "INSERT INTO doctor_info (name, spatiality, expr_years, gender, nationality, email, day_work) 
                        VALUES (:name, :specialty, :experience, :gender, :nationality, :email, :working_days)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'name' => $PostData['name'],
            'specialty' => $PostData['specialty'],
            'experience' => $PostData['experience'],
            'gender' => $PostData['gender'],
            'nationality' => $PostData['nationality'],
            'email' => $PostData['email'],
            'working_days' => $working_days
        ]);
        $_SESSION['message'] = "Doctor added successfully!";

    }
    else{
        include 'doctor_form.php';
        exit();
    }
}

function Edit_Doctor($pdo, $PostData)
{
    if (isset($PostData['update'])) 
    {
        $working_days = isset($PostData['working_days']) ? implode(',', $PostData['working_days']) : '';
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
            'id' => $PostData['doc_id'],
            'name' => $PostData['name'],
            'specialty' => $PostData['specialty'],
            'experience' => $PostData['experience'],
            'gender' => $PostData['gender'],
            'nationality' => $PostData['nationality'],
            'email' => $PostData['email'],
            'working_days' => $working_days
        ]);
        $_SESSION['message'] = "Doctor updated successfully!";
    }
    else{
        $doctor = getDoctorById($pdo, $PostData['doc_id']);
        include 'doctor_form.php';
        exit();
    }
}

function Delete_Doctor($pdo, $PostData)
{
    $sql = "DELETE FROM doctor_info WHERE doc_no = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $PostData['doc_id']]);
    $_SESSION['message'] = "Doctor deleted successfully!";
}


// Handle all doctor-related actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    switch ($action) {
        case 'add':
            Add_Doctor($pdo, $_POST);
            break;

        case 'edit':
            Edit_Doctor($pdo, $_POST);
            break;

        case 'delete':
            Delete_Doctor($pdo, $_POST);
            break;
    }
    
    header("Location: admin.php");
    exit();
}

