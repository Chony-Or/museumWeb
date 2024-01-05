<?php
session_start();

// Include the necessary files
include('includes/db_connect.php');
include('includes/authenticate.php');

// Check if the logged-in user is an evaluator (You should have a role or similar in your database)
//if ($_SESSION['role'] !== 'evaluator') {
    // Redirect to dashboard or unauthorized page
//    header('Location: dashboard.php');
//    exit();
//}

// Fetch all student data from the database
$sql = "SELECT id, firstName, lastName, game_time FROM students";
$result = $conn->query($sql);
$studentsData = ($result->num_rows > 0) ? $result->fetch_all(MYSQLI_ASSOC) : [];

// HTML Document
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>EVALUATOR PROFILE</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/style.css"> <!-- Add additional styles for the dashboard if needed -->
    <link rel="stylesheet" href="css/profile.css"> <!-- Include the new dashboard styles -->
</head>
<body>

<div class="sidenav">
        <a href="main.php"><i class="fas fa-home icon"></i>Home</a>
        <a href="Dashboard.php"><i class="fas fa-tachometer-alt icon"></i>Dashboard</a>
        <a href="profile.php"><i class="fas fa-user icon"></i>My Profile</a>
        <a href="leaderboard.php"><i class="fas fa-trophy icon"></i>Leaderboard</a>
    </div>

    <img src="res/GamePic3.png" class="img-fluid" id="bg-img">
    
    <div class="profile-container">
    
        <h1>Evaluator Profile</h1>

        <?php if (!empty($studentsData)) : ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Student Name</th>
                        <th>Game Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($studentsData as $student) : ?>
                        <tr>
                            <td><?php echo $student['id']; ?></td>
                            <td><?php echo $student['firstName'] . ' ' . $student['lastName']; ?></td>
                            <td><?php echo $student['game_time']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>No student data found.</p>
        <?php endif; ?>

        <!-- Add additional evaluator information as needed -->

        <a href="dashboard.php" class="button">Back to Dashboard</a>
        <a href="logout.php" class="button">Logout</a>
    </div>
</body>
</html>
