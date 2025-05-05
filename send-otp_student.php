<?php
session_start();
include ('dataconnection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['forget_pass'])) {
    $student_email = $_POST['student_email'];

    // Check if the email exists in the database
    $stmt = $connection->prepare("SELECT * FROM student_information WHERE student_email = ?");
    $stmt->execute([$student_email]);
    $rowCount = $stmt->rowCount();

    if ($rowCount > 0) {
        // Generate a random OTP
        $otp = rand(100000, 999999);
        $_SESSION['otp'] = $otp;
        $_SESSION['mail'] = $student_email;
        require "Mail/phpmailer/PHPMailerAutoload.php";
        $mail = new PHPMailer;

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';

        $mail->Username = 'mmuhostelfyp69@gmail.com';
        $mail->Password = 'webtbfkazkbryfok';

        $mail->setFrom('mmuhostelfyp69@gmail.com', 'Password Reset OTP');
        $mail->addAddress($_POST["student_email"]);

        $mail->isHTML(true);
        $mail->Subject = "Password Reset OTP";
        $mail->Body = "<p>Dear user,</p> <h3>Your password reset OTP is $otp<br></h3>
        <br><br>
        <p>Regards,</p>
        <b>MMU Hostel</b>";

        if (!$mail->send()) {
            ?>
            <script>
                alert("<?php echo "Failed to send OTP. Please try again." ?>");
            </script>
            <?php
        } else {
            ?>
            <script>
                alert("<?php echo "OTP sent to " . $student_email ?>");
                window.location.replace('verification.php');
            </script>
            <?php
        }
    } else {
        ?>
        <script>
            alert("User with email does not exist!");
        </script>
        <?php
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forget Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="" />
	<meta name="author" content="http://code4berry.com" />
	<!-- css --> 
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="materialize/css/materialize.min.css" media="screen,projection" />
	<link href="css2/bootstrap.min.css" rel="stylesheet" />
	<link href="css2/fancybox/jquery.fancybox.css" rel="stylesheet"> 
	<link href="css2/flexslider.css" rel="stylesheet" /> 
	<link rel="stylesheet" type="text/css" href="css2/zoomslider.css" />
	<link href="css2/style.css" rel="stylesheet" />

    <style>
        /* CSS样式 */
        .center-container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            position: relative; /* 添加相对定位 */
        }

        .content-box {
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #f2f2f2;
            max-width: 400px;
            width: 200%;
        }

        /* 更新样式 */
        h2 {
            color: #e91e63;
            position: absolute; /* 添加绝对定位 */
            top: 100px; /* 负值使其上移 */
            left: 50%;
            transform: translateX(-50%); /* 水平居中 */
        }

        label {
            font-size: 20px;
        }

        input[type="submit"] {
            background-color: #e91e63;
        }
    </style>
    
</head>
<body>
    
    <?php include('include/header.php') ?>
    
    <div class="center-container">
        <div class="content-box">
        <h2 style="color: #e91e63;">Retrieve your password</h2>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="student_email" style="font-size: 20px; color: black;">Enter your email:</label>
                <input type="email" name="student_email" id="student_email" required>
                <br>
                <input type="submit" name="forget_pass" value="Send OTP" style="background-color: #e91e63; color: white;">
            </form> 
        </div>
    </div>
    
    <?php include('include/footer.php') ?>

</body>
</html>
