<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) {
        // Handle login
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();

            // Verify password
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
            } else {
                $error = "Invalid password";
            }
        } else {
            $error = "Invalid username";
        }
    } elseif (isset($_POST['logout'])) {
        // Handle logout
        session_destroy();
        header('Location: login.php');
        exit();
    }
}