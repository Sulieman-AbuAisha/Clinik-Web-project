<?php
include '../PDO/PDO.php';
session_start();
var_dump($_GET);

if(isset($_SESSION['username'])){
    header("Location: index.php");
    return;
}

$showSignup = isset($_GET['signup']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Portal</title>
    <link rel="stylesheet" href="../CSS/Appointment.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="appointment-container">
        <!-- Login Form -->
        <div class="auth-section" id="loginSection" <?php if($showSignup) echo 'style="display:none;"'; ?>>
            <h2>Patient Login</h2>
            <form action="process_login.php" method="POST" id="loginForm">
                <div class="form-group">
                    <label for="login-username">Username:</label>
                    <input type="text" id="login-username" name="username" required>
                </div>  
                <div class="form-group">
                    <label for="login-password">Password:</label>
                    <input type="password" id="login-password" name="password" required>
                </div>
                <button type="submit" class="submit-btn">Login</button>
                <p>Don't have an account? <a href="?signup=1">Sign Up</a></p>
            </form>
        </div>

        <!-- Sign Up Form -->
        <div class="auth-section" id="signupSection" <?php if(!$showSignup) echo 'style="display:none;"'; ?>>
            <h2>Patient Registration</h2>
            <form action="process_signup.php" method="POST" id="signupForm">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="name">Full Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="gender">Gender:</label>
                    <select id="gender" name="gender" required>
                        <option value="">Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="nationality">Nationality:</label>
                    <input type="text" id="nationality" name="nationality" required>
                </div>
                <div class="form-group">
                    <label for="tel">Phone Number:</label>
                    <input type="tel" id="tel" name="tel" required placeholder="e.g., +1-234-567-8900">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="confirm-password">Confirm Password:</label>
                    <input type="password" id="confirm-password" name="confirm-password" required>
                </div>
                <button type="submit" class="submit-btn">Sign Up</button>
                <p>Already have an account? <a href="?">Login</a></p>
            </form>
        </div>
    </div>
</body>
</html>
