<?php
require_once '../PDO/PDO.php';
session_start();

// Check admin privileges
if (!IsAdmin()) {
    header("Location: ../Sign/Sign.php");
    exit();
}

// Search functionality
$search = isset($_GET['search']) ? $_GET['search'] : '';
$searchColumn = isset($_GET['search_column']) ? $_GET['search_column'] : 'name';

// Modify the searchQuery
$searchQuery = !empty($search) ? 
    "WHERE $searchColumn LIKE :search" : "";

// Fetch doctors
function getDoctors($pdo, $searchQuery, $search) {
    $sql = "SELECT * FROM doctor_info " . $searchQuery;
    $stmt = $pdo->prepare($sql);
    
    if (!empty($search)) {
        $searchParam = "%$search%";
        $stmt->bindParam(':search', $searchParam);
    }
    
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$doctors = getDoctors($pdo, $searchQuery, $search);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Doctors Management</title>
    <link rel="stylesheet" href="../CSS/admin-styles.css">
</head>
<body>
    <nav>
        <div class="logo">Admin Panel</div>
        <ul>
            <li><a href="../index.php">Home</a></li>
            <li><a href="../Sign/logout.php">Logout</a></li>
        </ul>
    </nav>

    <div class="container">
        <h2>Doctors Management</h2>
        
        <!-- Search Bar -->
        <div class="search-bar">
            <form method="GET">
                <select name="search_column">
                    <option value="name" <?= $searchColumn === 'name' ? 'selected' : '' ?>>Name</option>
                    <option value="spatiality" <?= $searchColumn === 'spatiality' ? 'selected' : '' ?>>Specialty</option>
                    <option value="gender" <?= $searchColumn === 'gender' ? 'selected' : '' ?>>Gender</option>
                    <option value="nationality" <?= $searchColumn === 'nationality' ? 'selected' : '' ?>>Nationality</option>
                    <option value="email" <?= $searchColumn === 'email' ? 'selected' : '' ?>>Email</option>
                    <option value="day_work" <?= $searchColumn === 'day_work' ? 'selected' : '' ?>>Working Days</option>
                </select>
                <input type="text" name="search" placeholder="Search doctors..." value="<?= htmlspecialchars($search) ?>">
                <button type="submit" class="btn btn-search">Search</button>
            </form>
            <form action="doctor_actions.php" method="POST">
                <input type="hidden" name="action" value="add">
                <button type="submit" class="btn btn-add">Add New Doctor</button>
            </form>
        </div>

        <!-- Doctors Table -->
        <table class="doctors-table">
            <thead>  
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Specialty</th>
                    <th>Experience</th>
                    <th>Gender</th>
                    <th>Nationality</th>
                    <th>Email</th>
                    <th>Working Days</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($doctors as $doctor): ?>
                    <tr>
                        <td><?= htmlspecialchars($doctor['doc_no']) ?></td>
                        <td><?= htmlspecialchars($doctor['name']) ?></td>
                        <td><?= htmlspecialchars($doctor['spatiality']) ?></td> 
                        <td><?= htmlspecialchars($doctor['expr_years']) ?> years</td>
                        <td><?= htmlspecialchars($doctor['gender']) ?></td>
                        <td><?= htmlspecialchars($doctor['nationality']) ?></td>
                        <td><?= htmlspecialchars($doctor['email']) ?></td>
                        <td><?= htmlspecialchars($doctor['day_work']) ?></td>
                        <td class="actions">
                            <form action="doctor_actions.php" method="POST" class="action-form">
                                <input type="hidden" name="doc_id" value="<?= $doctor['doc_no'] ?>">
                                <button type="submit" name="action" value="edit" class="btn btn-edit">Edit</button>
                                <button type="submit" name="action" value="delete" class="btn btn-delete" 
                                        onclick="return confirm('Are you sure you want to delete this doctor?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>