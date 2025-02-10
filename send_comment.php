<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $comment = htmlspecialchars($_POST['comment']);

    $to = "yoururbanhome23@gmail.com";
    $subject = "New Comment Submission";
    $body = "Comment: $comment";
    $headers = "From: no-reply@yoururbanhome.com";

    if (mail($to, $subject, $body, $headers)) {
        echo json_encode(["message" => "Comment sent successfully!"]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "Failed to send comment."]);
    }
} else {
    http_response_code(405);
    echo json_encode(["error" => "Invalid request method."]);
}
?>
