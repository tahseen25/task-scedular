<?php
require_once 'functions.php';

$message = "";

if (isset($_GET['email'])) {
    $email = trim($_GET['email']);
    $code = generateVerificationCode();
    file_put_contents(__DIR__ . '/unsubscribe_codes.txt', "$email|$code\n", FILE_APPEND);
    sendUnsubscribeVerificationEmail($email, $code);
    $message = "A confirmation code was sent to $email.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['unsubscribe_email'], $_POST['unsubscribe_verification_code'])) {
    $email = trim($_POST['unsubscribe_email']);
    $code = trim($_POST['unsubscribe_verification_code']);
    if (verifyCode($email, $code, 'unsubscribe_codes.txt')) {
        unsubscribeEmail($email);
        $message = "You have been unsubscribed.";
    } else {
        $message = "Invalid confirmation code.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Unsubscribe</title>
</head>
<body>
    <h1>Unsubscribe</h1>
    <form method="POST">
        <input type="email" name="unsubscribe_email" required placeholder="Enter your email">
        <input type="text" name="unsubscribe_verification_code" required placeholder="Enter code">
        <button type="submit" id="unsubscribe-button">Unsubscribe</button>
    </form>
    <p><?php echo $message; ?></p>
</body>
</html>