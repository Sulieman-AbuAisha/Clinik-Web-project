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
    
        if(!filter_var($data["email"], FILTER_VALIDATE_EMAIL))
        {
            $Error['email'] = "Invalid email format";
        }
    
        if(!preg_match("/^\+[0-9]{1,3}-[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $data["tel"]))
        {
            $Error['tel'] = "Phone number must be in format: +XXX-XXX-XXX-XXXX";
        }
    
        if($data["password"] !== $data["confirm-password"])
        {
            $Error['password'] = "Passwords do not match";
        }
    
        return empty($Error);
    }
?>