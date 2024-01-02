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

    <title>LEADERBOARD</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/leaderboard.css">
    <!-- Add additional styles for the leaderboard if needed -->
</head>
<body>
    <!-- Header Section -->
    <div class="sidenav">
        <a href="main.php"><i class="fas fa-home icon"></i>Home</a>
        <a href="Dashboard.php"><i class="fas fa-tachometer-alt icon"></i>Dashboard</a>
        <a href="profile.php"><i class="fas fa-user icon"></i>My Profile</a>
        <a href="leaderboard.php"><i class="fas fa-trophy icon"></i>Leaderboard</a>
    </div>
    
    <img src="res/GamePic3.png" class="img-fluid" id="bg-img">

    <div class="leaderboard-container">
        <h1>Leaderboard</h1>

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