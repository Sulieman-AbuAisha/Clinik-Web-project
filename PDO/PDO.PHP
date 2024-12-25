<?php
  $host =  'localhost';
  $user = 'root'; 
  $password = '';
  $dbname = 'clinic';

  // Set DSN
  $dsn = 'mysql:host='. $host .';dbname='. $dbname;

  // Create a PDO instance
  $pdo = new PDO($dsn, $user, $password);
  $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

  function IsAdmin(){
    if (isset($_SESSION['user']))
    {
      if($_SESSION['user'] != false)
        return $_SESSION['user']['priv'] == 1;
    }
    return false;
  }

  function IsUser(){
    if (isset($_SESSION['user']))
    {
      if($_SESSION['user'] != false)
        return $_SESSION['user']['priv'] == 2;
    }
    return false;
  }

// function checkAdminPrivileges() {
//     if (!isset($_SESSION['user']) || $_SESSION['priv'] != 1) {
//         header("Location: ../Sign/Sing.php");
//         exit();
//     }
// }
?>
