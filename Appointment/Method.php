<?php 
    require_once './PDO_Appointment.php';

    function HandleScheduleAppointment($data, &$errors){
        if(empty($data['doctor_select'])){
            $errors['schedule_appointment'] = "Please select a doctor";
            return false;
        }
        
        if(isDoctorFreeinDate($data['doctor_select'], $data['appointmentDate'])){
            if(insertAppointment($data)){
                $errors['schedule_appointment_success'] = "Appointment scheduled successfully";
                return true;
            }
            else{
                $errors['schedule_appointment'] = "Failed to schedule appointment";
            }
        }
        else{
            $errors['schedule_appointment'] = "Doctor is not free in this date";
        }
    }
?>