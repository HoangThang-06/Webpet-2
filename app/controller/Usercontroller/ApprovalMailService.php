<?php
require __DIR__ . '/../PHPMailer/Exception.php';
require __DIR__ . '/../PHPMailer/PHPMailer.php';
require __DIR__ . '/../PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ApprovalMailService {

    private $fromEmail = 'hoangtrongthang10102006@gmail.com';
    private $fromName  = 'Adoption System';
    private $smtpUser  = 'hoangtrongthang10102006@gmail.com';
    private $smtpPass  = 'pzpc lpqu vpsg bldh';

    public function sendApprovalMail($userEmail, $petName) {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = $this->smtpUser;
            $mail->Password   = $this->smtpPass;
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom($this->fromEmail, $this->fromName);
            $mail->addAddress($userEmail);

            $mail->isHTML(true);
            $mail->Subject = "Yêu cầu nhận nuôi đã được duyệt";
            $mail->Body = "
                <h3>Xin chúc mừng!</h3>
                <p>Yêu cầu nhận nuôi thú cưng <strong>$petName</strong> của bạn đã được <strong>duyệt</strong>.</p>
                <p>Hãy liên hệ để nhận thú cưng nhé!</p>
            ";

            $mail->send();
            return ["status" => true, "message" => "Mail sent successfully"];
        } catch (Exception $e) {
            return ["status" => false, "message" => "Send failed: " . $mail->ErrorInfo];
        }
    }
}
/* cach dung
require 'ApprovalMailService.php';

$adoptionId = $_POST['id'] ?? null;
if ($adoptionId) {
    // Cập nhật trạng thái
    $conn->query("UPDATE adoption SET status='approved' WHERE id=$adoptionId");

    // Lấy email và tên pet
    $result = $conn->query("
        SELECT u.email, p.name 
        FROM adoption a
        JOIN users u ON a.id_user=u.id_user
        JOIN pets p ON a.id_pet=p.id
        WHERE a.id=$adoptionId
    ");
    $data = $result->fetch_assoc();

    // Gửi mail
    $mailService = new ApprovalMailService();
    $mailService->sendApprovalMail($data['email'], $data['name']);

    echo "<script>alert('Yêu cầu đã được duyệt và email thông báo đã gửi!');</script>";
}
*/