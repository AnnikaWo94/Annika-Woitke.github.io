<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = trim($_POST["message"]);

    // Prüfen, ob Felder gefüllt sind
    if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Bitte füllen Sie alle Felder korrekt aus.";
        exit;
    }

    $to = "info@woitke.de";
    $subject = "Neue Kontaktanfrage von $name";
    $body = "Name: $name\nE-Mail: $email\n\nNachricht:\n$message";
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";

    // Mail senden
    if (mail($to, $subject, $body, $headers)) {
        echo "Vielen Dank! Ihre Nachricht wurde gesendet.";
    } else {
        http_response_code(500);
        echo "Beim Senden der Nachricht ist ein Fehler aufgetreten.";
    }
} else {
    http_response_code(403);
    echo "Es ist ein Problem aufgetreten, bitte versuchen Sie es erneut.";
}
?>
