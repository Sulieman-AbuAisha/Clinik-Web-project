<?php
session_start();
require_once './ValidateMethod.php';
require_once './PDO_Sing.php';


$errors = [];
$showSignup = isset($_GET['signup']) || isset($_POST['submitSignup']);
echo $_SERVER["REQUEST_METHOD"];
var_dump($showSignup);

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle Signup
    if(isset($_POST['submitSignup'])) {
        handleSignup($_POST, $errors);
    }
    // Handle Login 
    else if(isset($_POST['submitLogin'])) {
        handleLogin($_POST);
    }
} // Add this closing brace

function handleSignup($postData, &$errors) {
    if(!validateSignup($postData, $errors)) {
        header('Location: Sign.php?signup=1');
        exit();
    }
    
    if(insertSignup($postData)) {
        $_SESSION['success'] = "Account created successfully!";
        header('Location: Sign.php');
    } else {
        $_SESSION['signup_errors']['general'] = "Error creating account";
        header('Location: Sign.php?signup=1');
    }
    exit();
}

function handleLogin($postData) {
    if(!Login($postData['username'], $postData['password'])) {
        $_SESSION['loginError'] = "Invalid username or password";
        header('Location: Sign.php');
    } else {
        header('Location: ../Appointment.php');
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Portal</title>
    <link rel="stylesheet" href="../CSS/Sign.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="appointment-container">
        <!-- Login Form -->
        <div class="auth-section" <?php if($showSignup) echo 'style="display:none;"'; ?>>
            <h2>Patient Login</h2>
            <form action="Sign.php" method="POST" id="loginForm">
                <div class="form-group">
                    <label for="login-username">Username:</label>
                    <input type="text" id="login-username" name="username">
                </div> 
                <div class="form-group">
                    <label for="login-password">Password:</label>
                    <input type="password" id="login-password" name="password">
                </div>
                <?php if(isset($_SESSION['loginError'])): ?>
                    <p class='error'>Invalid username or password</p>
                    <?php unset($_SESSION['loginError']); ?>    
                <?php endif; ?>           
                <button type="submit" class="submit-btn" name="submitLogin">Login</button>
                <p>Don't have an account? <a href="?signup=1">Sign Up</a></p>
            </form>
        </div>

        <!-- Sign Up Form -->
        <div class="auth-section" <?php if(!$showSignup) echo 'style="display:none;"'; ?>>
            <h2>Patient Registration</h2>
            <form action="Sign.php" method="POST" id="signupForm">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" require ="<?php isset($_SESSION['form_data']["username"])? htmlspecialchars($_SESSION['form_data']["username"]): '';?>">
                    <?php  if(isset($errors['username']))  echo "<span class='error'>". $errors['username'] ."</span>" ?>
                </div>
                <div class="form-group">
                    <label for="name">Full Name:</label>
                    <input type="text" id="name" name="name"  value="<?php echo isset($_SESSION['form_data']['name']) ? htmlspecialchars($_SESSION['form_data']['name']) : ''; ?>">
                    <?php if(isset($errors['name'])) echo "<span class='error'>". $errors['name'] ."</span>" ?>
                </div>
                <div class="form-group">
                    <label for="gender">Gender:</label>
                    <select id="gender" name="gender" >
                        <option value="">Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                    <?php if(isset($errors['gender'])) echo "<span class='error'>". $errors['gender'] ."</span>" ?>
                </div>
                <div class="form-group">
                    <label for="nationality">Nationality:</label>
                    <select id="nationality" name="nationality" >
                        <option value=""></option>
                        <option value="Libya">Libya</option>
                        <option value="Tunisia">Tunisia</option>
                        <option value="Morocco">Morocco</option>
                        <option value="Algeria">Algeria</option>
                        <option value="Egypt">Egypt</option>          
                    </select>
                    <?php if(isset($errors['nationality'])) echo "<span class='error'>". $errors['nationality'] ."</span>" ?>
                </div>
                <div class="form-group">
                    <label for="tel">Phone Number:</label>
                    <input type="tel" id="tel" name="tel"  placeholder="e.g., +1-234-567-8900">
                    <?php if(isset($errors['tel'])) echo "<span class='error'>". $errors['tel'] ."</span>" ?>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" >
                    <?php if(isset($errors['email'])) echo "<span class='error'>". $errors['email'] ."</span>" ?>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" >
                    <?php if(isset($errors['password'])) echo "<span class='error'>". $errors['password'] ."</span>" ?>
                </div>
                <div class="form-group">
                    <label for="confirm-password">Confirm Password:</label>
                    <input type="password" id="confirm-password" name="confirm-password" >
                    <?php if(isset($errors['confirm-password'])) echo "<span class='error'>". $errors['confirm-password'] ."</span>" ?>
                </div>
                <span class="error" style="display: block;" ><?php if(isset($_SESSION['signup_errors']['general'])) echo $_SESSION['signup_errors']['general']; ?></span>
                <button type="submit" class="submit-btn" name="submitSignup">Sign Up</button>
                <p>Already have an account? <a href="?">Login</a></p>
            </form>
        </div>
    </div>
</body>
</html>
