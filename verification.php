<?php session_start();
include('dataconnection.php');
?>

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">



    <link rel="icon" href="Favicon.png">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

    <title>Verification</title>
</head>
<body style="background-color: f2f2f2;">

<nav class="navbar navbar-expand-lg navbar-light navbar-laravel">
    <div class="container">
    <a class="navbar-brand" style="font-size: 50px; color: #e91e63; margin-left: 330px;" href="#">Reset Your Password</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>

<main class="login-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header"style="color: #e91e63;">Reset Password</div>
                    <div class="card-body">
    <div class="text-center"> <!-- Added 'text-center' class -->
        <form action="#" method="POST">
            <div class="form-group row">
                <label for="email_address" class="col-md-4 col-form-label text-md-right" style="font-size: 20px; color: black;">OTP    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                <div class="col-md-8">
                    <input type="text" id="otp" class="form-control" name="otp_code" required autofocus>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-8 offset-md-4">
                <input type="submit" value="Verify" name="verify" style="background-color: #e91e63; color: black; border-color: black; border-width: 2px;">
                </div>
            </div>
        </form>
</br><p class="w3l-register-p" style="color: black;">Go back Main <a href="home.php" class="register">Home</a></p>
    </div>
</div>
            </div>
        </div>
    </div>
    </div>

</main>
</body>
</html>
<?php
include('dataconnection.php');
if(isset($_POST["verify"])){
    $otp = $_SESSION['otp'];
    $student_email = $_SESSION['mail'];
    $otp_code = $_POST['otp_code'];

    if($otp != $otp_code){
        ?>
        <script>
            alert("Invalid OTP code");
        </script>
        <?php
    } else {
        header("Location: update-newpass.php"); // Redirect to the update-newpass.php page
        exit; // Make sure to exit after the redirect
    }
}
?>