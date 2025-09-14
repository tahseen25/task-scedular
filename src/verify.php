<?php
require_once 'functions.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'], $_POST['code'])) {
    $email = trim($_POST['email']);
    $code = trim($_POST['code']);
    if (verifyCode($email, $code)) {
        registerEmail($email);
        $message = "Email verified and registered successfully.";
    } else {
        $message = "Invalid verification code.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Verify Email</title>
</head>
<body>
    <h1>Email Verification</h1>
    <form method="POST">
        <input type="email" name="email" required placeholder="Enter your email">
        <input type="text" name="code" required placeholder="Enter code">
        <button type="submit" id="verify-button">Verify</button>
    </form>
    <p><?php echo $message; ?></p>
</body>
</html>