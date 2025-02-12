<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/SMTP.php';

header('Content-Type: application/json');
$logFile = 'log.txt';

function logMessage($message) {
    global $logFile;
    file_put_contents($logFile, date('Y-m-d H:i:s') . " - " . $message . "\n", FILE_APPEND);
}

logMessage("Script started");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    logMessage("POST request received");
    $input = json_decode(file_get_contents('php://input'), true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        logMessage("JSON decode error: " . json_last_error_msg());
        http_response_code(400);
        echo json_encode(["error" => "Invalid JSON data."]);
        exit;
    }

    $name = htmlspecialchars($input['name']);
    $email = htmlspecialchars($input['email']);
    $message = htmlspecialchars($input['message']);

    logMessage("Input processed: Name - $name, Email - $email, Message - $message");

    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
        $mail->SMTPAuth = true;
        $mail->Username = 'yoururbanhome23@gmail.com'; // SMTP username
        $mail->Password = 'chapelhill23'; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        logMessage("SMTP settings configured");

        //Recipients
        $mail->setFrom('yoururbanhome23@gmail.com', 'Your Urban Home'); // Set the fixed email address as the sender
        $mail->addAddress('yoururbanhome23@gmail.com'); // Add your fixed email address as the recipient

        logMessage("Recipients set");

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'New Contact Form Submission';
        $mail->Body    = "Name: $name<br>Email: $email<br>Message: $message";
        logMessage("Email content set");

        $mail->send();
        logMessage("Email sent successfully");
        echo json_encode(["message" => "Message sent successfully!"]);
    } catch (Exception $e) {
        logMessage("Mailer Error: {$mail->ErrorInfo}");
        http_response_code(500);
        echo json_encode(["error" => "Failed to send message. Mailer Error: {$mail->ErrorInfo}"]);
    }
} else {
    logMessage("Invalid request method");
    http_response_code(405);
    echo json_encode(["error" => "Invalid request method."]);
}

logMessage("Script ended");
?>
