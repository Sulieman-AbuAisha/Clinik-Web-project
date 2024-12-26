<?php
    require_once '../PDO/PDO.PHP';

    function getAllspatiality() {
        global $pdo;
        $spatiality = [];
        try {
            $sql = "SELECT DISTINCT spatiality FROM doctor_info";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $spatiality = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $spatiality;
        }
        catch(PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }

    }

    function GetAllDoctors(){
        global $pdo;
        $doctors = [];

        try {
            $stmt = $pdo->prepare("SELECT * FROM doctor_info");
            $stmt->execute();
            $doctors = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $doctors;
            
        } catch(PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
   
    }
    function GetAllDoctorsBy($spatiality){
        global $pdo;
        $doctors = [];

        try {
            $stmt = $pdo->prepare("SELECT * FROM doctor_info WHERE spatiality = :spatiality");
            $stmt->bindParam(':spatiality', $spatiality);
            $stmt->execute();
            $doctors = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $doctors;
            
        } catch(PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
   
    }

    function isDoctorFreeinDate($doctor_select, $appointmentDate) { 
    try {
        global $pdo;
        $sql = "SELECT COUNT(*) as appointment_count FROM doctor_info 
                INNER join resv_info on resv_info.d_no = doctor_info.doc_no
                where doctor_info.doc_no = :doc_no 
                and resv_info.Date = :Date 
                and resv_info.Type = 'confirm'";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':doc_no', $doctor_select);
        $stmt->bindParam(':Date', $appointmentDate);
        $stmt->execute();
            
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['appointment_count'] < 10;
    }
    catch(PDOException $e) {
        error_log("Database Error: " . $e->getMessage());
        return false;
    }
    }   

    function insertAppointment($data){
        try{
            global $pdo;
            $sql = "INSERT INTO resv_info (u_no, d_no, Date, Type) VALUES (:u_no, :d_no, :Date, 'confirm')";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':u_no', $_SESSION['user']['u_No']);
            $stmt->bindParam(':d_no', $data['doctor_select']);
            $stmt->bindParam(':Date', $data['appointmentDate']);
            $stmt->execute();
            return true;
        }
        catch(PDOException $e){
            error_log("Database Error: " . $e->getMessage());
            $_SESSION["schedule_appointment"] = "Error: " . $e->getMessage();
            var_dump($_SESSION);
            return false;
        }
    }

    function getPatientAppointments($user_id)    {
        global $pdo;
        try{
            $sql = "SELECT * FROM doctor_info INNER join resv_info on resv_info.d_no = doctor_info.doc_no
                where  u_no = :user_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
            $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $appointments;
        }
        catch(PDOException $e){
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
        
    }

    function cancelAppointment($appointment_id, $user_id) {
        global $pdo;
        try {
            $sql =  "UPDATE resv_info  SET Type = 'Cancelled' 
            WHERE r_no = :r_no";
    
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':r_no', $appointment_id);
            $result = $stmt->execute();

            if ($result) {
                $_SESSION['message'] = 'Appointment cancelled successfully';
            } else {
                $_SESSION['error'] = 'Failed to cancel appointment';
            }
        } 
        catch(PDOException $e) {
            $_SESSION['error'] = 'Database error: ' . $e->getMessage();
            return false;
        }

    }
?>