<?php
// Include PHPMailer library
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load PHPMailer
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Define some constants
define("RECIPIENT_NAME", "John Doe");
define("RECIPIENT_EMAIL", "capricornj10@gmail.com");

// SMTP configuration
define("SMTP_HOST", "mail.themerange.net");
define("SMTP_PORT", 465);
define("SMTP_USERNAME", "info@themerange.net");
define("SMTP_PASSWORD", "@l38vf3h~Kjw");
define("SMTP_SECURE", "ssl"); // 'ssl' or 'tls'

// Read the form values
$userName = isset($_POST['name']) ? preg_replace("/[^\.\-\' a-zA-Z0-9]/", "", $_POST['name']) : "";
$senderEmail = isset($_POST['email']) ? preg_replace("/[^\.\-\' a-zA-Z0-9]/", "", $_POST['email']) : "";
$senderSubject = isset($_POST['sub']) ? preg_replace("/[^\.\-\' a-zA-Z0-9]/", "", $_POST['sub']) : "";
$message = isset($_POST['message']) ? preg_replace("/(From:|To:|BCC:|CC:|Message:|Content-Type:)/", "", $_POST['message']) : "";

// If all values exist, send the email
if ($userName && $senderEmail && $senderSubject && $message) {
    $mail = new PHPMailer(true);

    try {
        // SMTP settings
        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USERNAME;
        $mail->Password = SMTP_PASSWORD;
        $mail->SMTPSecure = SMTP_SECURE;
        $mail->Port = SMTP_PORT;

        // Email settings
        $mail->setFrom(SMTP_USERNAME, $userName);
        $mail->addAddress(RECIPIENT_EMAIL, RECIPIENT_NAME);
        $mail->Subject = $senderSubject;
        $mail->Body = $message;
        $mail->isHTML(false);

        $mail->send();

        // Redirect on success
        header('Location: contact-us.html?message=Successfull');
    } catch (Exception $e) {
        // Log the error and redirect
        error_log("Mailer Error: " . $mail->ErrorInfo);
        header('Location: index.html?message=Failed');
    }
} else {
    // Redirect if inputs are invalid
    header('Location: index.html?message=Failed');
}
?>
