<?php
require __DIR__ . '/../PHPMailer/Exception.php';
require __DIR__ . '/../PHPMailer/PHPMailer.php';
require __DIR__ . '/../PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailService {

    public function sendOTP($email) {
        session_start();

        $otp = rand(100000, 999999);

        $_SESSION['reset_email']  = $email;
        $_SESSION['reset_otp']    = $otp;
        $_SESSION['reset_expire'] = time() + 300; // 5 phút

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'hoangtrongthang10102006@gmail.com';
            $mail->Password   = 'pzpc lpqu vpsg bldh';
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom('hoangtrongthang10102006@gmail.com', 'Recovery System');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = "Mã khôi phục mật khẩu";
            $mail->Body =
                "<h3>Mã OTP của bạn là:</h3>
                 <h1 style='color:red;'>$otp</h1>
                 <p>Có hiệu lực trong 5 phút.</p>";

            $mail->send();

            return [
                "status" => true,
                "message" => "OTP sent successfully",
                "otp" => $otp
            ];

        } catch (Exception $e) {
            return [
                "status" => false,
                "message" => "Send failed: " . $mail->ErrorInfo
            ];
        }
    }
}
