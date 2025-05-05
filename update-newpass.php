<?php
session_start();
include('dataconnection.php');

if(isset($_POST['update_password'])) {
    $student_email = $_SESSION['mail'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Perform password validation and matching
    if($new_password !== $confirm_password) {
        ?>
        <script>
            alert("Passwords do not match.");
        </script>
        <?php
    } else {
        // Hash the new password
        $password_hash = password_hash($new_password, PASSWORD_BCRYPT);

        // Update the password in the database
        $stmt = $connection->prepare("UPDATE student_information SET student_password = :password_hash WHERE student_email = :email");
        $stmt->bindParam(':password_hash', $password_hash);
        $stmt->bindParam(':email', $student_email);

        try {
            $stmt->execute();
            ?>
            <script>
                alert("Password updated successfully.");
                window.location.replace("login.php");
            </script>
            <?php
        } catch (PDOException $e) {
            ?>
            <script>
                alert("Failed to update password. Please try again.");
            </script>
            <?php
        }
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Update Password</title>

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
    <!-- Add your CSS styles and other dependencies here -->
    <style>
        .form-container {
            max-width: 500px;
            margin: 40px auto; /* Updated to add margin */
            padding: 40px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f2f2f2;
        }

        .form-container h2 {
            text-align: center;
        }

        .form-container label {
            display: block;
            margin-bottom: 5px;
            font-size: 20px; /* Increased font size */
            color: black; /* Set color to black */
        }

        .form-container input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
        }

        .form-container button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            width: 100%;
        }

        .form-container button[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Updated footer styles */
        .footer-container {
            margin-top: 4cm;
            text-align: center;
            background-color: #f2f2f2;
            padding: 20px 0;
        }
    </style>
</head>

<body>
    <?php include('include/header.php') ?> <!-- Move the header above the form -->
    <div class="form-container">
        <form action="#" method="POST">
            <h2>Update Password</h2>
            <div>
                <label style="font-size: 20px; color: black;">New Password</label> <!-- Updated font size and color -->
                <input type="password" name="new_password" required>
            </div>
            <div>
                <label style="font-size: 20px; color: black;">Confirm Password</label> <!-- Updated font size and color -->
                <input type="password" name="confirm_password" required>
            </div>
            <div>
                <button type="submit" name="update_password"style="background-color: #e91e63; color: black; border-color: black; border-width: 2px;">Update Password</button>
            </div>
        </form>
    </div>

    <div class="footer-container">
        <?php include('include/footer.php') ?> <!-- Move the footer below the form -->
    </div>
    <a href="#" class="scrollup waves-effect waves-dark"><i class="fa fa-angle-up HillSide"></i></a>
	<script src="js/jquery.js"></script>
	<script src="js/jquery.easing.1.3.js"></script>
	<script src="materialize/js/materialize.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.fancybox.pack.js"></script>
	<script src="js/jquery.fancybox-media.js"></script>  
	<script src="js/jquery.flexslider.js"></script>
	<script src="js/animate.js"></script>
	<!-- Vendor Scripts -->
	<script src="js/modernizr.custom.js"></script>
	<script src="js/jquery.zoomslider.min.js"></script>
	<script src="js/jquery.isotope.min.js"></script>
	<script src="js/jquery.magnific-popup.min.js"></script>
	<script src="js/animate.js"></script> 
	<script src="js/custom.js"></script>
</body>
</body>
</html>