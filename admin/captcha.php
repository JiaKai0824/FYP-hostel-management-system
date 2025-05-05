<?php
require_once 'vendor/autoload.php'; // Include the reCAPTCHA library

// Your CAPTCHA configuration
$recaptchaSiteKey = '6LcWS54mAAAAAEac5narXJY7167kNXg_1qT7vdy9';
$recaptchaSecretKey = '6LcWS54mAAAAAB9SNJjAN94DLma55IhCLudZjgeM';

// Verify the CAPTCHA response
$recaptcha = new \ReCaptcha\ReCaptcha($recaptchaSecretKey);
$recaptchaResponse = $_POST['g-recaptcha-response'];
$recaptchaResult = $recaptcha->verify($recaptchaResponse);

if (!$recaptchaResult->isSuccess()) {
    // CAPTCHA validation failed
    echo json_encode(['success' => false, 'message' => 'Invalid CAPTCHA']);
    exit;
}

// CAPTCHA validation succeeded
echo json_encode(['success' => true]);
?>
