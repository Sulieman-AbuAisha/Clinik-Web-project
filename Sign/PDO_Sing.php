<?php
    require_once '../PDO/PDO.PHP'; 

function Login($username, $password, $priv) {
    global $pdo;
    try{
        $sql = "select * from users where u_name = :username and password = :password and priv = :priv";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':priv', $priv);

        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $_SESSION['user'] = $user;
        

        return $user;
    }
    catch(PDOException $e){
        error_log("Database Error: " . $e->getMessage());
    }
}

function insertSignup($data){
    global $pdo;
    try {
        $sql = "INSERT INTO users (u_name, password, Priv) VALUES (:username, :password, '2')";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":username", $data['username']);
        $stmt->bindParam(":password", $data['password']);

        $stmt->execute();
        $stmt->fetch();

        $last_inserted_id = $pdo->lastInsertId();


        $sql = "INSERT INTO patient_info (U_no, name, gender, nationality, tel, email) 
                VALUES (:U_No, :name, :gender, :nationality, :tel, :email)";
        
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':U_No', $last_inserted_id);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':gender', $data['gender']);
        $stmt->bindParam(':nationality', $data['nationality']);
        $stmt->bindParam(':tel', $data['tel']);
        $stmt->bindParam(':email', $data['email']);
        
        return $stmt->execute();
        
    } catch(PDOException $e) {
        error_log("Database Error: " . $e->getMessage());
        return false;
    }
}
?>