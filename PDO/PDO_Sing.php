<?php
    require_once 'PDO.PHP';

function LoginAdmin($username, $password) {
    global $pdo;
    $isFound = false;
    try{
        $sql = "select * from users where u_name = :username and password = :password and priv = '1'";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);

        $stmt->execute();
        $isFound = $stmt->rowCount() > 0;
        
    }
    catch(PDOException $e){
        error_log("Database Error: " . $e->getMessage());
    }

    return $isFound;
}


function insertSignup($data){
    global $pdo;
    try {
        $sql = "INSERT INTO users (u_name, fullname, gender, nationality, phone, email, password, priv) 
                VALUES (:username, :name, :gender, :nationality, :phone, :email, :password, '2')";
        
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':gender', $data['gender']);
        $stmt->bindParam(':nationality', $data['nationality']);
        $stmt->bindParam(':phone', $data['tel']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $data['password']);
        
        return $stmt->execute();
    } catch(PDOException $e) {
        error_log("Database Error: " . $e->getMessage());
        return false;
    }
}
?>