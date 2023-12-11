<?php
session_start();

// Include necessary files
include('includes/db_connect.php');
include('includes/authenticate.php');

// Fetch data from students table
$sql = "SELECT students.id, students.username, students.game_time_completed, leaderboard.duration
        FROM students
        LEFT JOIN leaderboard ON students.username = leaderboard.username";
$result = $conn->query($sql);
$players = ($result->num_rows > 0) ? $result->fetch_all(MYSQLI_ASSOC) : [];


// HTML Document
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameBase Learning App - Leaderboard</title>
    <link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/leaderboard.css">
    <!-- Add additional styles for the leaderboard if needed -->
</head>
<body>
    <!-- Header Section -->
    <header class="header">
        <div class="logo">GameBase Learning App</div>
        <nav class="navbar">
            <a href="dashboard.php">Dashboard</a>
            <a href="profile.php">My Profile</a>
            <a href="leaderboard.php">Leaderboard</a>
        </nav>
    </header>

    <div class="leaderboard-container">
        <h1>GameBase Learning App Leaderboard</h1>

        <!-- Display player data in a table -->
        <?php if (!empty($players)) : ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Game Time Completed</th>
                        <th>Duration</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($players as $player) : ?>
                        <tr>
                            <td><?php echo $player['id']; ?></td>
                            <td><?php echo $player['username']; ?></td>
                            <td><?php echo $player['game_time_completed']; ?></td>
                            <td><?php echo $player['duration']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>No players found.</p>
        <?php endif; ?>

        <!-- Logout button -->
        <a href="logout.php" class="button">Logout</a>
    </div>
</body>
</html>