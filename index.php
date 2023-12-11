<?php
session_start();

// Include the database connection file
include('includes/db_connect.php');

// Include the authentication file
include('includes/authenticate.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// You can now display the main content of your application here
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameBase Learning App</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Welcome to GameBase Learning App, <?php echo $_SESSION['username']; ?>!</h1>
    <!-- Your game-based learning content goes here -->

    <a href="logout.php">Logout</a>
</body>
</html>