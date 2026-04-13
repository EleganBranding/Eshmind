<?php

define("RECIPIENT_NAME", "Eshmind");
define("RECIPIENT_EMAIL", "mirunalini@eshmind.com");

// Read and sanitize form values
$userName    = isset($_POST['username']) ? trim(strip_tags($_POST['username'])) : '';
$senderEmail = isset($_POST['email']) ? trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL)) : '';
$userPhone   = isset($_POST['phone']) ? trim(strip_tags($_POST['phone'])) : '';
$userSubject = isset($_POST['subject']) ? trim(strip_tags($_POST['subject'])) : '';
$message     = isset($_POST['message']) ? trim(strip_tags($_POST['message'])) : '';

// Check required fields
if (empty($userName) || empty($senderEmail) || empty($userPhone) || empty($userSubject) || empty($message)) {
    header("Location: contact.html?message=Failed");
    exit;
}

// Validate email
if (!filter_var($senderEmail, FILTER_VALIDATE_EMAIL)) {
    header("Location: contact.html?message=InvalidEmail");
    exit;
}

// Email details
$to = RECIPIENT_EMAIL;
$subject = "New Contact Form Submission: " . $userSubject;

$body  = "You have received a new message from your website contact form.\n\n";
$body .= "Name: " . $userName . "\n";
$body .= "Email: " . $senderEmail . "\n";
$body .= "Phone: " . $userPhone . "\n";
$body .= "Subject: " . $userSubject . "\n";
$body .= "Message:\n" . $message . "\n";

// IMPORTANT: use your domain email if available
$headers  = "From: Eshmind Website <noreply@eshmind.com>\r\n";
$headers .= "Reply-To: " . $senderEmail . "\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// Send email
if (mail($to, $subject, $body, $headers)) {
    header("Location: contact.html?message=Successful");
    exit;
} else {
    header("Location: contact.html?message=Failed");
    exit;
}
?>