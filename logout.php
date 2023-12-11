<?php
session_start();
session_destroy();
echo 'You have been logged out.';
?>
<!DOCTYPE html>
<a href="login.php" class="button">Logout</a>
</html>