<?php
session_start();
require_once 'ValidateMethod.php'; 
require_once 'PDO_Sing.php';
$errors = [];

$showSignup = isset($_GET['signup']) || isset($_POST['submitSignup']);
//var_dump($_SERVER["REQUEST_METHOD"]);

if($_SERVER['REQUEST_METHOD'] === 'GET') {
    if(isset($_GET['priv'])) {
        $_SESSION['priv'] = $_GET['priv'];
    }
}
var_dump($_SESSION);
//var_dump($_SESSION);


if($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle Signup
    if(isset($_POST['submitSignup'])) {
       // var_dump($_SESSION);
        handleSignup($_POST, $errors);
    }
    // Handle Login 
    else if(isset($_POST['submitLogin'])) {
       // var_dump($_SESSION);
        $privilege = isset($_SESSION['priv']) ? $_SESSION['priv'] : '';
        handleLogin($_POST, $privilege);
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
    <script src="./validation.js"></script>
</head>
<body>
    <div class="login Sign-container" <?php if($showSignup) echo 'style="display:none;"'; ?>>
            <!-- Login Form -->
        <div class="auth-section" >
            <h2>Login</h2>
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
                <p <?php echo $_SESSION['priv'] === '1' ? 'style="display:none;"' : '' ?>>Don't have an account? <a href="?signup=1">Sign Up</a></p>
            </form>
        </div>
    </div>

    <div class="Signup Sign-container" <?php if(!$showSignup) echo 'style="display:none;"'; ?>>
        <!-- Sign Up Form -->
        <div class="auth-section" >
            <h2>Patient Registration</h2>
            <form action="Sign.php?signup=1" method="POST" id="signupForm" onsubmit="return validate()">
                <div class="form-row">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" value="<?php echo isset($_POST["username"]) ? htmlspecialchars($_POST["username"]) : ''; ?>">
                        <?php if(isset($_SESSION['signup_errors']['username'])) echo "<span class='error'>". $_SESSION['signup_errors']['username'] ."</span>" ?>
                        <span id="username_error" class="error"></span>
                    </div>
                    <div class="form-group">
                        <label for="name">Full Name:</label>
                        <input type="text" id="name" name="name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
                        <?php if(isset($_SESSION['signup_errors']['name'])) echo "<span class='error'>". $_SESSION['signup_errors']['name'] ."</span>" ?>
                        <span id="name_error" class="error"></span>

                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="gender">Gender:</label>
                        <select id="gender" name="gender" >
                            <option value="" >Select Gender</option>
                            <option value="male" <?php echo isset($_POST['gender']) && $_POST['gender'] == 'male' ? 'selected' : ''; ?>>Male</option>
                            <option value="female" <?php echo isset($_POST['gender']) && $_POST['gender'] == 'female' ? 'selected' : ''; ?>>Female</option>
                        </select>
                        <?php if(isset($_SESSION['signup_errors']['gender'])) echo "<span class='error'>". $_SESSION['signup_errors']['gender'] ."</span>" ?>
                    </div>
                    <div class="form-group">
                        <label for="nationality">Nationality:</label>
                        <select id="nationality" name="nationality" >
                            <option value="" ></option>
                            <option value="Libya" <?php echo isset($_POST['nationality']) && $_POST['nationality'] == 'Libya' ? 'selected' : ''; ?>>Libya</option>
                            <option value="Tunisia" <?php echo isset($_POST['nationality']) && $_POST['nationality'] == 'Tunisia' ? 'selected' : ''; ?>>Tunisia</option>
                            <option value="Morocco" <?php echo isset($_POST['nationality']) && $_POST['nationality'] == 'Morocco' ? 'selected' : ''; ?>>Morocco</option>
                            <option value="Algeria" <?php echo isset($_POST['nationality']) && $_POST['nationality'] == 'Algeria' ? 'selected' : ''; ?>>Algeria</option>
                            <option value="Egypt" <?php echo isset($_POST['nationality']) && $_POST['nationality'] == 'Egypt' ? 'selected' : ''; ?>>Egypt</option>          
                        </select>
                        <?php if(isset($_SESSION['signup_errors']['nationality'])) echo "<span class='error'>". $_SESSION['signup_errors']['nationality'] ."</span>" ?>
                        <span id="nationality_error" class="error"></span>

                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="tel">Phone Number:</label>
                        <input type="tel" id="tel" name="tel"  placeholder="0931234567"
                         value="<?php echo isset($_POST['tel']) ? htmlspecialchars($_POST['tel']) : ''; ?>">
                        <?php if(isset($_SESSION['signup_errors']['tel'])) echo "<span class='error'>". $_SESSION['signup_errors']['tel'] ."</span>" ?>
                        <span id="tel_error" class="error"></span>

                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" 
                        value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                        <?php if(isset($_SESSION['signup_errors']['email'])) echo "<span class='error'>". $_SESSION['signup_errors']['email'] ."</span>" ?>
                        <span id="email_error" class="error"></span>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password">
                        <?php if(isset($_SESSION['signup_errors']['password'])) echo "<span class='error'>". $_SESSION['signup_errors']['password'] ."</span>" ?>
                        <span id="password_error" class="error"></span>
                    </div>
                    <div class="form-group">
                        <label for="confirm-password">Confirm Password:</label>
                        <input type="password" id="confirm-password" name="confirm-password" >
                        <?php if(isset($_SESSION['signup_errors']['confirm-password'])) echo "<span class='error'>". $_SESSION['signup_errors']['confirm-password'] ."</span>" ?>
                    </div>
                </div>
                    <span class="error" style="display: block;" ><?php if(isset($_SESSION['signup_errors']['general'])) echo $_SESSION['signup_errors']['general']; ?></span>
                    <span class="success" style="display: block;" ><?php if(isset($_SESSION['success'])) echo $_SESSION['success']; ?></span>
                    <button type="submit" class="submit-btn" name="submitSignup">Sign Up</button>
                    <p>Already have an account? <a href="?">Login</a></p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
