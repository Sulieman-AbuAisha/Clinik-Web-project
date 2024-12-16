<?php
  $host =  'localhost';
  $user = 'root';
  $password = '';
  $dbname = 'Clinic';

  // Set DSN
  $dsn = 'mysql:host='. $host .';dbname='. $dbname;

  // Create a PDO instance
  $pdo = new PDO($dsn, $user, $password);
  $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);


function getDoctors() {
    global $pdo;
    try {
        $stmt = $pdo->prepare("SELECT doc_no, name FROM doctor_Info ORDER BY name ASC");
        $stmt->execute();
        
        $doctors = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $doctors[] = [
                'id' => $row['doc_no'],
                'name' => $row['name']
            ];
            foreach($doctors as $doctor){
                echo $doctor['name'] . '<br>';
              }
        }
        return $doctors;
        
    } catch(PDOException $e) {
        error_log("Database Error: " . $e->getMessage());
        return false;
    }
}

?>
