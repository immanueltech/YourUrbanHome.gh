<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $comment = $data['comment'];

    $to = 'yoururbanhome23@gmail.com';
    $subject = 'New Comment from Your Urban Home';
    $message = "You have received a new comment:\n\n" . $comment;
    $headers = 'From: no-reply@yoururbanhome.com' . "\r\n" .
               'Reply-To: no-reply@yoururbanhome.com' . "\r\n" .
               'X-Mailer: PHP/' . phpversion();

    if (mail($to, $subject, $message, $headers)) {
        echo json_encode(['success' => true]);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to send email']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}
?>
