<?php
session_start();

// Include necessary files
include('includes/db_connect.php');
include('includes/authenticate.php');

// Fetch player data from the database
$sql = "SELECT id, firstName, lastName, student_section, game_time FROM students";
$result = $conn->query($sql);
$players = ($result->num_rows > 0) ? $result->fetch_all(MYSQLI_ASSOC) : [];

// Calculate total players
$totalPlayers = count($players);

// Calculate the count of students and average game time per section
$sectionData = []; // Array to store section-wise data

foreach ($players as $player) {
    $section = $player['student_section'];

    // Count the number of students per section
    if (!isset($sectionData[$section]['count'])) {
        $sectionData[$section]['count'] = 1;
    } else {
        $sectionData[$section]['count']++;
    }

    // Calculate the total game time per section
    if (!isset($sectionData[$section]['totalGameTime'])) {
        // Convert the time string to a timestamp
        $sectionData[$section]['totalGameTime'] = strtotime($player['game_time']);
    } else {
        // Check if the existing value is a valid timestamp before adding to it
        if (is_numeric($sectionData[$section]['totalGameTime'])) {
            // Convert the player's game time to a timestamp and add it to the existing value
            $sectionData[$section]['totalGameTime'] += strtotime($player['game_time']);
        } else {
            // Handle the case where the existing value is not a valid timestamp (optional)
            // For example, set it to the player's game time
            $sectionData[$section]['totalGameTime'] = strtotime($player['game_time']);
        }
    }
    
}

// Calculate the average game time per section
foreach ($sectionData as $section => $data) {
    $sectionData[$section]['averageGameTime'] = ($data['count'] > 0) ? $data['totalGameTime'] / $data['count'] : "N/A";
}


// HTML Document
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/style.css">

    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <title>DASHBOARD</title>
</head>
<body>

    <div class="sidenav">
        <a href="main.php"><i class="fas fa-home icon"></i>Home</a>
        <a href="Dashboard.php"><i class="fas fa-tachometer-alt icon"></i>Dashboard</a>
        <a href="profile.php"><i class="fas fa-user icon"></i>My Profile</a>
        <a href="leaderboard.php"><i class="fas fa-trophy icon"></i>Leaderboard</a>
    </div>

    <img src="res/GamePic3.png" class="img-fluid" id="bg-img">
    
    <!-- Main Content Section -->
    <div class="dashboard-container">
    
        <h1>Dashboard</h1>

        <!-- Display total players -->
        <p>Total Players: <?php echo $totalPlayers; ?></p>

        <!-- Display count of students and average game time per section -->
        <?php if (!empty($sectionData)) : ?>
            <h2>Section-wise Data:</h2>
            <ul>
                <?php foreach ($sectionData as $section => $data) : ?>
                    <li>
                        Section <?php echo $section; ?>:
                        <ul>
                            <li>Number of Students: <?php echo $data['count']; ?></li>
                            <li>Average Game Time: <?php echo $data['averageGameTime']; ?></li>
                        </ul>
                    </li>
                <?php endforeach; ?>
            </ul>

            <!-- Display pie chart -->
            <div class="canvas-container">
                 <canvas id="pieChart" width="300" height="300"></canvas>
            </div>

<script>
    // Create pie chart
    var ctx = document.getElementById('pieChart').getContext('2d');
    var pieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode(array_keys($sectionData)); ?>,
            datasets: [{
                data: <?php echo json_encode(array_column($sectionData, 'count')); ?>,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(255, 206, 86, 0.8)',
                    'rgba(75, 192, 192, 0.8)',
                    'rgba(153, 102, 255, 0.8)',
                    'rgba(255, 159, 64, 0.8)',
                ],
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            title: {
                display: true,
                text: 'Student Distribution by Section',
                fontSize: 16,
            },
        },
    });
</script>

<?php else : ?>
    <p>No players found.</p>
<?php endif; ?>

<!-- Logout button -->
<a href="main.php" class="button">Back</a>
<a href="logout.php" class="button">Logout</a>

</div>
</body>
</html>

