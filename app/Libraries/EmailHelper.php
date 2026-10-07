<?php
namespace App\Libraries;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailHelper
{
    public function sendEmail($to, $subject, $message, $attachment = null)
    {
        $mail = new PHPMailer(true);

        try {
            // SMTP Configuration
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com'; // Change if using another SMTP
            $mail->SMTPAuth   = true;
            $mail->Username   = 'orderconfirm@pawarhandloom.com'; // Your email
            $mail->Password   = 'Rzf2$xCK8]kv'; // Your email password or App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // Email Settings
            $mail->setFrom('orderconfirm@pawarhandloom.com', 'Pawar Handloom');
            $mail->addAddress($to); // Recipient email

            // Check for attachment
            if ($attachment) {
                $mail->addAttachment($attachment);
            }

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $message;

            if ($mail->send()) {
                return "Email sent successfully!";
            } else {
                return "Email could not be sent. Error: " . $mail->ErrorInfo;
            }
        } catch (Exception $e) {
            return "Email error: {$mail->ErrorInfo}";
        }
    }
}
