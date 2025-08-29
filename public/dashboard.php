<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<?php if ($_SESSION['is_admin']): ?>
    <p>You are an Admin (can manage all users’ data)</p>
<?php else: ?>
    <p>You are a normal user (can only manage your own data)</p>
<?php endif; ?>

<!DOCTYPE html>
<html>
<head><title>Dashboard</title></head>
<body>
    <h2>Welcome to Dashboard</h2>
    <p>You are logged in!</p>
    <a href="logout.php">Logout</a>
</body>
</html>
