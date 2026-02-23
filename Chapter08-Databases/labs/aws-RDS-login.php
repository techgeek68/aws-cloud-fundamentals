<?php
// login.php - Database connection login form
session_start();

$error = '';
$prev_host = '';
$prev_dbname = 'lab';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = trim($_POST['db_host'] ?? '');
    $user = trim($_POST['db_user'] ?? '');
    $pass = $_POST['db_pass'] ?? '';
    $dbname = trim($_POST['db_name'] ?? 'lab');

    $prev_host = htmlspecialchars($host);

    if ($host === '' || $user === '') {
        $error = 'Please provide both RDS endpoint and username.';
    } else {
        $mysqli = @new mysqli($host, $user, $pass, $dbname);
        if ($mysqli->connect_error) {
            $error = 'Connection failed: ' . htmlspecialchars($mysqli->connect_error);
        } else {
            $_SESSION['db_host'] = $host;
            $_SESSION['db_user'] = $user;
            $_SESSION['db_pass'] = $pass;
            $_SESSION['db_name'] = $dbname;
            $mysqli->close();
            header('Location: index.php');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Database Connection</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background-color: #f5f5f5; }
        .container { max-width: 500px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #333; text-align: center; }
        form { margin-top: 20px; }
        label { display: block; margin-bottom: 15px; color: #555; }
        input[type="text"], input[type="password"] { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; }
        .btn { background: #3498db; color: white; padding: 12px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; width: 100%; }
        .btn:hover { background: #2980b9; }
        .error { color: #e74c3c; margin-bottom: 15px; padding: 10px; background: #fadbd8; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔐 Database Connection</h1>
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="post">
            <label>
                <strong>RDS Endpoint:</strong>
                <input type="text" name="db_host" required value="<?php echo $prev_host; ?>" placeholder="your-rds-endpoint.region.rds.amazonaws.com">
            </label>
            <label>
                <strong>Username:</strong>
                <input type="text" name="db_user" required placeholder="admin">
            </label>
            <label>
                <strong>Password:</strong>
                <input type="password" name="db_pass" required placeholder="Enter your password">
            </label>
            <label>
                <strong>Database Name:</strong>
                <input type="text" name="db_name" value="<?php echo $prev_dbname; ?>" placeholder="lab">
            </label>
            <input type="submit" value="Connect to Database" class="btn">
        </form>
    </div>
</body>
</html>
