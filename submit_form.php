<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input = json_decode(file_get_contents('php://input'), true);
    $name = htmlspecialchars($input['name']);
    $email = htmlspecialchars($input['email']);
    $message = htmlspecialchars($input['message']);

    $to = "yoururbanhome23@gmail.com";
    $subject = "New Contact Form Submission";
    $body = "Name: $name\nEmail: $email\n\nMessage:\n$message";
    $headers = "From: $email";

    if (mail($to, $subject, $body, $headers)) {
        echo json_encode(["message" => "Message sent successfully!"]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Failed to send message."]);
    }
} else {
    http_response_code(405);
    echo json_encode(["error" => "Invalid request method."]);
}
?>
