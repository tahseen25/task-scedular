<?php
require_once 'functions.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = trim($_POST['email']);
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $code = generateVerificationCode();
        file_put_contents(__DIR__ . '/verification_codes.txt', "$email|$code\n", FILE_APPEND);
        sendVerificationEmail($email, $code);
        $message = "Verification code sent to $email.";
    } else {
        $message = "Invalid email.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Task Scheduler - Register</title>
</head>
<body>
    <h1>Register Email</h1>
    <form method="POST">
        <input type="email" name="email" required placeholder="Enter your email">
        <button type="submit" id="register-button">Register</button>
    </form>
    <p><?php echo $message; ?></p>
</body>
</html>