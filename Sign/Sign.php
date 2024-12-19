<?php
session_start();
require_once '../PDO/PDO.php';
require_once './ValidateMethod.php';
require_once '../PDO/PDO_Sing.php';


$errors = [];
$showSignup = isset($_GET['signup']);
  // Check if the user is already logged in with a valid session
//   if(isset($_SESSION['username'])){
//       echo "you are logged in " . $_SESSION['username'];
//       return;
//   }

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    //signup
    if(!isset($showSignup))
    {
        if(!validateSignup($_POST, $errors)) {
            header('Location: Sign.php?signup=1');
            exit();
        }
        else
        {
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $password;
            //send the user to the appointment page
        }
    }
    //Login
    else {
        if(!LoginAdmin($_POST['username'], $_POST["password"])) {
            $_SESSION['loginError'] = "Invalid username or password";
            header('Location: Sign.php');
            exit();                     
        }
        else {
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['password'] = $_POST["password"];
            unset($_SESSION['loginError']); // Clear any previous errors
            header('Location: ../Test.php');
            exit();
        }
    }
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
            <form action="./Sign.php" method="POST" id="loginForm">
                <div class="form-group">
                    <label for="login-username">Username:</label>
                    <input type="text" id="login-username" name="username" required>
                </div> 
                <div class="form-group">
                    <label for="login-password">Password:</label>
                    <input type="password" id="login-password" name="password" required>
                </div>
                <?php if(isset($_SESSION['loginError'])): ?>
                    <p class='error'>Invalid username or password</p>
                    <?php unset($_SESSION['loginError']); ?>    
                <?php endif; ?>           
                <button type="submit" class="submit-btn" name="submit">Login</button>
                <p>Don't have an account? <a href="?signup=1">Sign Up</a></p>
            </form>
        </div>

        <!-- Sign Up Form -->
        <div class="auth-section" <?php if(!$showSignup) echo 'style="display:none;"'; ?>>
            <h2>Patient Registration</h2>
            <form action="./Sign.php" method="POST" id="signupForm">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" require value="<?php isset($_SESSION['form_data']["username"])? htmlspecialchars($_SESSION['form_data']["username"]): '';?>">
                    <?php  if(isset($_SESSION['signup_errors']['username']))  echo "<span class='error'>". $_SESSION['signup_errors']['username'] ."</span>" ?>
                </div>
                <div class="form-group">
                    <label for="name">Full Name:</label>
                    <input type="text" id="name" name="name" required value="<?php echo isset($_SESSION['form_data']['name']) ? htmlspecialchars($_SESSION['form_data']['name']) : ''; ?>">
                    <?php if(isset($_SESSION['signup_errors']['name'])) echo "<span class='error'>". $_SESSION['signup_errors']['name'] ."</span>" ?>
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
