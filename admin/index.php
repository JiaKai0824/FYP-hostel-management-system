<?php
session_start();

include('includes/config.php');
if (isset($_POST['login'])) {
    $captchaUrl = 'captcha.php';
    $captchaResponse = file_get_contents($captchaUrl, false, stream_context_create(['http' => ['method' => 'POST', 'content' => http_build_query($_POST)]]));
    $captchaResult = json_decode($captchaResponse, true);

    if ($captchaResult !== null && isset($captchaResult['success']) && !$captchaResult['success']) {
        echo "<script>alert('Invalid CAPTCHA');</script>";
    } else {
       
        $username = $_POST['username'];
        $password = $_POST['password'];

  
        $stmt = $mysqli->prepare("SELECT id, username, email, password, superadmin, status FROM admin WHERE (username=? OR email=?)");
        $stmt->bind_param('ss', $username, $username);
        $stmt->execute();
        $stmt->bind_result($id, $username, $email, $hashedPassword, $superadmin, $status);
        $rs = $stmt->fetch();

        if ($rs) {
          
            if (password_verify($password, $hashedPassword)) {
                if ($status == 0) {
                    $_SESSION['status'] = $status;
                    echo "<script>alert('Your account has been disabled. Please contact the superadmin.');</script>";
                    echo "<script>window.location.href='index.php';</script>";
                    exit; 
                } elseif ($superadmin == 1) {
                    $_SESSION['id'] = $id;
                    header("location: manage-admin.php");
                    exit; 
                } else {
                    $_SESSION['id'] = $id;
                    header("location: admin-profile.php");
                    exit; 
                }
            } else {
                echo "<script>alert('Invalid Username/Email or password');</script>";
            }
        } else {
            echo "<script>alert('Invalid Username/Email or password');</script>";
        }
    }
}
?>

<!doctype html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Admin login</title>
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <link rel="stylesheet" href="css/fileinput.min.css">
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <div class="login-page bk-img" style="background-image: url(img/login.jpg);">
        <div class="form-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <h1 class="text-center text-bold text-light mt-4x">Hostel Management System</h1>
                        <div class="well row pt-2x pb-3x bk-light">
                            <div class="col-md-8 col-md-offset-2">
                                <form action="" class="mt" method="post">
                                    <label for="" class="text-uppercase text-sm">Your Email</label>
                                    <input type="text" placeholder="Username" name="username" class="form-control mb">
                                    <label for="" class="text-uppercase text-sm">Password</label>
                                    <input type="password" placeholder="Password" name="password" class="form-control mb">
                                    <div class="g-recaptcha" data-sitekey="6LcWS54mAAAAAEac5narXJY7167kNXg_1qT7vdy9" data-callback="enableLoginButton"></div>
                                    <br>
									<button type="submit" name="login" id="loginButton" class="btn btn-primary btn-block" disabled>Login</button>
                                </form>
                                <script>
                                    function enableLoginButton() {
                                        document.getElementById("loginButton").disabled = false;
                                    }
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script src="js/Chart.min.js"></script>
    <script src="js/fileinput.js"></script>
    <script src="js/chartData.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
