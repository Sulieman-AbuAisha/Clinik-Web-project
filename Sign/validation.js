const Pat_username = /^[A-Z][a-zA-Z]{7}$/;
const Pat_name = /^[a-zA-Z]+\s[a-zA-Z]+$/;
const Pat_email = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
const Pat_tel = /^[0][0-9]{9}$/;
const Pat_password = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
const Pat_nationality = /^[A-Z][a-zA-Z]{2,}$/;
const Pat_age = /^(?:1[0-9]|[2-9][0-9])$/; 
const Pat_address = /^[A-Za-z0-9\s,.-]{10,100}$/;

function validate() {
    let isfound = true; 

    if (!Pat_username.test(document.getElementsByName("username")[0].value)) {
        document.getElementById("username_error").innerHTML = "Username must start with capital letter and be 8 characters long";
        isfound = false;
    }
    
    if (!Pat_name.test(document.getElementsByName("name")[0].value)) {
        document.getElementById("name_error").innerHTML = "Full name must contain first and last name";
        isfound = false;
    }
    
    if (!Pat_email.test(document.getElementsByName("email")[0].value)) {
        document.getElementById("email_error").innerHTML = "Invalid email format";
        isfound = false;
    }
    
    if (!Pat_tel.test(document.getElementsByName("tel")[0].value)) {
        document.getElementById("tel_error").innerHTML = "Phone number must be in format: 0XXXXXXXXX";
        isfound = false;
    }

    return isfound;
}