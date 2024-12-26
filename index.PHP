<?php      
require_once "PDO/PDO.PHP";  
    session_start();
    // session_destroy();
    var_dump($_SESSION); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthCare Clinic</title>
    <link rel="stylesheet" href="CSS/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <nav>
        <div class="logo">
            <i class="fas fa-heartbeat"></i>
            HealthCare Clinic
        </div>
        <ul>
            <li><a href="#home">Home</a></li>
            <li><a style="" href="<?php echo (IsAdmin() === true? "Admin/admin.php" : "Sign/Sign.php?priv=1")?>" >Admin</a></li>
            <li><a href=" <?php echo (IsUser() === true? "Appointment/schedule.php" : "Sign/Sign.php?priv=2") ?>" >Appointments</a></li>
        </ul>
    </nav>

    <header id="home">
        <div class="hero-content">
            <h1>Your Health Is Our Priority</h1>
            <p>Professional healthcare services with experienced doctors</p>
            <a href=" <?php echo (isset($_SESSION['user']) && $_SESSION['user'] != false && $_SESSION['user']['priv'] == 2)? "./Appointment/schedule.php" : "Sign/Sign.php?priv=2" ?>"  class="appointment-btn">Book Appointment</a>
        </div>
        <div class="doctor-image">
            <div class="icon top-left">
                <img src="pic/Calendar-icon.png" alt="Calendar Icon" />
            </div>

            <div class="icon top-right">
                <img src="pic/clinic-64.png" alt="Chat Icon" />
            </div>

            <img src="Pic/doctor.png" alt="Hero Image">

            <div class="icon bottom-left">
                <img src="pic/schedule-icon.png" alt="Schedule Icon" />
            </div>
        </div>
    </header>

    <section id="services">
        <h2>Our Services</h2>
        <div class="services-grid">
            <div class="service-card">
                <i class="fas fa-user-md"></i>
                <h3>General Medicine</h3>
                <p>Comprehensive medical care for all ages</p>
            </div>
            <div class="service-card">
                <i class="fas fa-heart"></i>
                <h3>Cardiology</h3>
                <p>Expert heart care and treatments</p>
            </div>
            <div class="service-card">
                <i class="fas fa-brain"></i>
                <h3>Neurology</h3>
                <p>Specialized neurological treatments</p>
            </div>
        </div>
    </section>

    <section id="doctors">
        <h2>Meet Our Doctors</h2>
        <div class="doctors-grid">
            <div class="doctor-card">
                <div class="doctor">
                    <img src="pic/doctor (1).png" alt="Dr. Sarah">
                    <div class="doctor-info">
                        <h3>Dr. Sarah Smith</h3>
                        <p>General Medicine</p>
                    </div>
                </div>
            </div>
            <div class="doctor-card">
                <div class="doctor">
                    <img src="pic/doctor (2).png" alt="Dr. James">
                    <div class="doctor-info">
                        <h3>Dr. James Johnson</h3>
                        <p>Cardiologist</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
