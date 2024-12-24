<?php
    function validateSignup($data, &$Error)   {
        if(!preg_match("/^[A-Z][a-zA-Z]{7}$/", $data["username"]))
        {
            $Error['username'] = "Username must start with capital letter and be 8 characters long";
        }

        if(!preg_match("/^[a-zA-Z]+\s[a-zA-Z]+$/", $data["name"]))
        {
            $Error['name'] = "Full name must contain first and last name";
        }

        // Add gender validation
        if(empty($data["gender"]))
        {
            $Error['gender'] = "Please select a gender";
        }

        // Add nationality validation
        if(empty($data["nationality"]))
        {
            $Error['nationality'] = "Please enter a valid nationality";
        }

        if(!filter_var($data["email"], FILTER_VALIDATE_EMAIL))
        {
            $Error['email'] = "Invalid email format";
        }
        
        if($data["password"] !== $data["confirm-password"])
        {
            $Error['password'] = "Passwords do not match";
        }

        if(!preg_match("/^[0][0-9]{9}$/", $data["tel"]))
        {
            $Error['tel'] = "Phone number must be in format: +0XXXXXXXXX";
        }

        if(empty($data["tel"]))
        {
            $Error['tel'] = "Please enter a phone number";
        }

        if(empty($data["password"]))
        {
            $Error['password'] = "Please enter a password";
        }

        if(empty($data["confirm-password"]))
        {
            $Error['confirm-password'] = "Please confirm your password";
        }

    
    
        return empty($Error);
    }

    function handleSignup($postData, &$errors) {
        if(!validateSignup($postData, $errors)) {
            $_SESSION['signup_errors'] = $errors;
            // header('Location: Sign.php?signup=1');
            return false;
        }
        var_dump($_SESSION['signup_errors']);
        
        
        if(insertSignup($postData)) {
            $_SESSION['signup_errors'] = "";
            $_SESSION['success'] = "Account created successfully!";
            // header('Location: Sign.php');
        } else {
            $_SESSION['signup_errors']['general'] = "Error creating account";
            return false;
        }
    }
    
    function handleLogin($postData, $priv) {
        if(Login($postData['username'], $postData['password'], $priv)) {
            if($priv == 1)
                header('Location: ../Admin/Doctor.php');
            else
                header('Location: ../Appointment/schedule.php');
        } else {
            $_SESSION['loginError'] = "Invalid username or password";
            return false;
        }
    }
?>