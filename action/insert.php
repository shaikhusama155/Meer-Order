<?php
// Include Composer's autoload
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// ========================================
// 1️⃣ Capture Form Data (From POST)
// ========================================
$username = isset($_POST['fullname']) ? trim($_POST['fullname']) : '';
$email    = isset($_POST['emailaddress']) ? trim($_POST['emailaddress']) : '';
$phone    = isset($_POST['contact']) ? trim($_POST['contact']) : '';
$msg      = isset($_POST['message']) ? trim($_POST['message']) : '';

$url       = isset($_POST['url']) ? $_POST['url'] : '';
$domain    = isset($_POST['domain']) ? $_POST['domain'] : '';
$subject   = isset($_POST['subject']) ? $_POST['subject'] : '';
$keyword   = isset($_POST['keyword']) ? $_POST['keyword'] : '';
$matchtype = isset($_POST['matchtype']) ? $_POST['matchtype'] : '';
$msclkid   = isset($_POST['msclkid']) ? $_POST['msclkid'] : '';
$gclid     = isset($_POST['gclid']) ? $_POST['gclid'] : '';

// Optional: basic validation
if (empty($username) || empty($email)) {
    echo json_encode(['status' => 'error', 'message' => 'Please provide name and email.']);
    exit;
}

// ========================================
// 2️⃣ Send Email via Hostinger SMTP
// ========================================
$mail = new PHPMailer(true);

try {
    // SMTP setup for Hostinger
    $mail->isSMTP();
    $mail->Host       = 'smtp.hostinger.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'meer@demowebsitepreviews.com'; // Your Hostinger email
    $mail->Password   = 'qjZx!?7*U';                     // Your Hostinger email password
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;

    // Optional for localhost testing
    $mail->SMTPOptions = [
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true,
        ],
    ];

    // $mail->SMTPDebug = 2; // enable for debugging if needed

    // Sender and recipient
    $mail->setFrom('meer@demowebsitepreviews.com', 'Meer Marriage');
    $mail->addAddress('meer@demowebsitepreviews.com'); // receiver email

    // Email content
    $mail->isHTML(true);
    $mail->Subject = 'Meer Marriage - New Lead Submission';
    $mail->Body = "
        <h2>New Lead Submission</h2>
        <p><strong>Name:</strong> {$username}</p>
        <p><strong>Email:</strong> {$email}</p>
        <p><strong>Phone:</strong> {$phone}</p>
        <p><strong>Message:</strong> {$msg}</p>
        <hr>
        <p><strong>URL:</strong> {$url}</p>
        <p><strong>Domain:</strong> {$domain}</p>
        <p><strong>Subject:</strong> {$subject}</p>
        <p><strong>Keyword:</strong> {$keyword}</p>
        <p><strong>Match Type:</strong> {$matchtype}</p>
        <p><strong>MSCLKID:</strong> {$msclkid}</p>
        <p><strong>GCLID:</strong> {$gclid}</p>
    ";

    // Send email
    if ($mail->send()) {
        echo json_encode(['status' => 'success', 'message' => 'Form submitted successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Email not sent.']);
    }

} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Mailer Error: ' . $mail->ErrorInfo]);
}
?>
