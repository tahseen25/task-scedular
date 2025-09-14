<?php
// src/functions.php

function generateVerificationCode() {
    return str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
}

function registerEmail($email) {
    $file = __DIR__ . '/registered_emails.txt';
    $emails = file_exists($file) ? file($file, FILE_IGNORE_NEW_LINES) : [];
    if (!in_array($email, $emails)) {
        file_put_contents($file, $email . PHP_EOL, FILE_APPEND);
    }
}

function unsubscribeEmail($email) {
    $file = __DIR__ . '/registered_emails.txt';
    $emails = file_exists($file) ? file($file, FILE_IGNORE_NEW_LINES) : [];
    $emails = array_filter($emails, fn($e) => $e !== $email);
    file_put_contents($file, implode(PHP_EOL, $emails) . PHP_EOL);
}

function sendVerificationEmail($email, $code) {
    $subject = "Your Verification Code";
    $body = "<p>Your verification code is: <strong>$code</strong></p>";
    sendEmail($email, $subject, $body);
}

function sendUnsubscribeVerificationEmail($email, $code) {
    $subject = "Confirm Unsubscription";
    $body = "<p>To confirm unsubscription, use this code: <strong>$code</strong></p>";
    sendEmail($email, $subject, $body);
}

function verifyCode($email, $code, $file = 'verification_codes.txt') {
    $lines = file(__DIR__ . '/' . $file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        [$e, $c] = explode('|', $line);
        if ($e === $email && $c === $code) {
            return true;
        }
    }
    return false;
}

function fetchGitHubTimeline() {
    $context = stream_context_create(['http' => ['user_agent' => 'PHP']]);
    return file_get_contents('https://api.github.com/events', false, $context);
}

function formatGitHubData($data) {
    $events = json_decode($data, true);
    $html = "<h2>GitHub Timeline Updates</h2><table border='1'><tr><th>Event</th><th>User</th></tr>";
    foreach ($events as $event) {
        $html .= "<tr><td>{$event['type']}</td><td>{$event['actor']['login']}</td></tr>";
    }
    $html .= "</table>";
    return $html;
}

function sendGitHubUpdatesToSubscribers() {
    $emails = file(__DIR__ . '/registered_emails.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $data = fetchGitHubTimeline();
    $html = formatGitHubData($data);

    foreach ($emails as $email) {
        $unsubscribeUrl = "http://localhost:8000/src/unsubscribe.php?email=" . urlencode($email);
        $body = $html . "<p><a href="$unsubscribeUrl" id="unsubscribe-button">Unsubscribe</a></p>";
        sendEmail($email, "Latest GitHub Updates", $body);
    }
}

function sendEmail($to, $subject, $body) {
    $headers  = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "From: noreply@taskscheduler.com\r\n";
    mail($to, $subject, $body, $headers);
}
?>