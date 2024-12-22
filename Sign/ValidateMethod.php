<?php
    function validateSignup($data, &$Error)
    {
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

        if(!preg_match("/^\+[0-9]{1,3}-[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $data["tel"]))
        {
            $Error['tel'] = "Phone number must be in format: +XXX-XXX-XXX-XXXX";
        }
    
    
        return empty($Error);
    }
?>