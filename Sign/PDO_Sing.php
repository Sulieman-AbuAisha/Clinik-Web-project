<?php
    require_once '../PDO/PDO.PHP';

function Login($username, $password) {
    global $pdo;
    try{
        $sql = "select * from users where u_name = :username and password = :password";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);

        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $_SESSION['user'] = $user;
        
        var_dump($_SESSION);

        return isset($user);
    }
    catch(PDOException $e){
        error_log("Database Error: " . $e->getMessage());
    }
}


function insertSignup($data){
    global $pdo;
    try {
        $sql = "INSERT INTO user (UserName, Password, Priv) VALUES (:username, :password, 2)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":username", $UserName);
        $stmt->bindParam(":password", $password);

        $stmt->execute();
        $stmt->fetch();

        $last_inserted_id = $pdo->lastInsertId();


        $sql = "INSERT INTO users (U_no, u_name, fullname, gender, nationality, phone, email, password, priv) 
                VALUES (:username, :name, :gender, :nationality, :phone, :email, :password, '2')";
        
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':U_No', $last_inserted_id);
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