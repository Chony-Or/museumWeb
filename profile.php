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
$sql = "SELECT id, username, game_time_started, game_time_completed FROM students";
$result = $conn->query($sql);
$studentsData = ($result->num_rows > 0) ? $result->fetch_all(MYSQLI_ASSOC) : [];

// HTML Document
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameBase Learning App - Dashboard</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Add additional styles for the dashboard if needed -->
    <link rel="stylesheet" href="css/dashboard.css"> <!-- Include the new dashboard styles -->
</head>
<body>
<header class="header">
        <div class="logo">GameBase Learning App</div>
        <nav class="navbar">
            <a href="dashboard.php">Dashboard</a>
            <a href="profile.php">My Profile</a>
            <a href="leaderboard.php">Leaderboard</a>
        </nav>
    </header>

    <div class="profile-container">
        <h1>Evaluator Profile</h1>

        <?php if (!empty($studentsData)) : ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Game Time Started</th>
                        <th>Game Time Completed</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($studentsData as $student) : ?>
                        <tr>
                            <td><?php echo $student['id']; ?></td>
                            <td><?php echo $student['username']; ?></td>
                            <td><?php echo $student['game_time_started']; ?></td>
                            <td><?php echo $student['game_time_completed']; ?></td>
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
