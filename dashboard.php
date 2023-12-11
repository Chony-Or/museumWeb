<?php
session_start();

// Include necessary files
include('includes/db_connect.php');
include('includes/authenticate.php');

// Fetch player data from the database
$sql = "SELECT id, username, game_time_started, game_time_completed FROM students";
$result = $conn->query($sql);
$players = ($result->num_rows > 0) ? $result->fetch_all(MYSQLI_ASSOC) : [];

// Calculate total players and average game time
$totalPlayers = count($players);
$averageGameTime = calculateAverageGameTime($players);

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

    <!-- Header Section -->
    <header class="header">
        <div class="logo">GameBase Learning App</div>
        <nav class="navbar">
            <a href="dashboard.php">Dashboard</a>
            <a href="profile.php">My Profile</a>
            <a href="leaderboard.php">Leaderboard</a>
        </nav>
    </header>

    <!-- Main Content Section -->
    <div class="dashboard-container">
        <h1>GameBase Learning App Dashboard</h1>

        <!-- Display total players and average game time -->
        <p>Total Players: <?php echo $totalPlayers; ?></p>
        <p>Average Game Time: <?php echo $averageGameTime; ?></p>

        <!-- Display player data in a table -->
        <?php if (!empty($players)) : ?>
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
                    <?php foreach ($players as $player) : ?>
                        <tr>
                            <td><?php echo $player['id']; ?></td>
                            <td><?php echo $player['username']; ?></td>
                            <td><?php echo $player['game_time_started']; ?></td>
                            <td><?php echo $player['game_time_completed']; ?></td>
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

<?php
// Function to calculate average game time
function calculateAverageGameTime($players)
{
    if (empty($players)) {
        return 'N/A';
    }

    $totalGameTime = 0;

    foreach ($players as $player) {
        $startTime = strtotime($player['game_time_started']);
        $endTime = strtotime($player['game_time_completed']);

        // Check if both start and end times are valid
        if ($startTime !== false && $endTime !== false) {
            $totalGameTime += ($endTime - $startTime);
        }
    }

    if ($totalGameTime > 0) {
        $averageGameTimeSeconds = $totalGameTime / count($players);
        return gmdate("H:i:s", $averageGameTimeSeconds);
    } else {
        return 'N/A';
    }
}
?>
