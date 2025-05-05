<?php
include 'dataconnection.php';
session_start();

if (isset($_SESSION['message'])) {
    // Display the message
    echo "<p class='success-message'>" . $_SESSION['message'] . "</p>";

    // Unset the message session variable
    unset($_SESSION['message']);
}

if (isset($_POST['user_id']) && isset($_POST['password'])) {
    $user_id = $_POST['user_id'];
    $password = $_POST['password'];

    // Prepare the SQL query to check whether the user is a student or a lecturer
$stmt = $connection->prepare("SELECT 'student_information' AS user_type, student_id AS user_id, student_password AS password_hash, student_name AS user_name, student_gender, status FROM student_information WHERE student_id = :user_id1 AND status = 1 UNION SELECT 'lecturer' AS user_type, lec_id AS user_id, lec_password AS password_hash, lec_name AS user_name, 'N/A' as student_gender, 1 as status FROM lecturer WHERE lec_id = :user_id2");


// Bind the user ID parameter to the prepared statement
$stmt->bindParam(':user_id1', $user_id);
$stmt->bindParam(':user_id2', $user_id);

// Execute the prepared statement
$stmt->execute();

    // Check whether the query returned a result
    if ($stmt->rowCount() > 0) {
        // The user ID exists
        $row = $stmt->fetch();
        $user_type = $row['user_type'];
        $user_id = $row['user_id'];
        $password_hash = $row['password_hash'];
		$student_gender = $row['student_gender'];

        // Verify the password
        if (password_verify($password, $password_hash)) {
            // Password is correct, set session variable for user name and redirect to home page
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_type'] = $user_type;
			$_SESSION['student_gender'] = $student_gender;
            header("Location: home.php");
            exit();
        } else {
            // Password is incorrect, redirect to login page with error message
            header("Location: login.php?error=invalid_credentials");
            exit();
        }
    } else {
        // User ID doesn't exist, redirect to login page with error message
        header("Location: login.php?error=account_disabled_or_invalid_credentials");
        exit();
    }
}

// Close the database connection
$connection = null;

?>



<!doctype html>
<html lang="en">
  <head>
  <title>Login </title>
    <meta charset="utf-8">

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

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="css/style.css">
	<link href="css2/style.css" rel="stylesheet" />

	</head>
	<body>

	<style>
		.nav.navbar-nav {
			display: flex;
			flex-direction: row;
		}

		.nav.navbar-nav li {
			margin-right: 5px; /* 可根据需要调整间距 */
		}

		.nav.navbar-nav li a:hover {
			text-decoration: none;
		}

		.navbar {
			height: 73px;
		}

		.navbar-brand {
  			margin-top: -10px;
  			margin-left: -10px;
		}

		.text-wrap {
			background:#e91e63;
		}

		.btn.btn-primary {
			background:#e91e63;
		}
	</style>

<header>
		<div class="navbar navbar-default navbar-static-top">
			<div class="container">
				<div class="navbar-header">
					<a class="navbar-brand" href="home.php"><i class="icon-info-blocks material-icons"></i> MMU Hostel&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
				</div>
				<div>
					<ul class="nav navbar-nav">
						<li class="HillSide"><a class="waves-effect waves-dark" href="javascript:void(0)" onclick="event.preventDefault(); location.href='home.php';">Home</a></li>
						<li><a class="waves-effect waves-dark" href="javascript:void(0)" onclick="event.preventDefault(); location.href='portfolio.php';">Gallery</a></li>
						<li><a class="waves-effect waves-dark" href="javascript:void(0)" onclick="event.preventDefault(); location.href='aboutus.php';">Contact</a></li>
						<li><a class="waves-effect waves-dark" href="javascript:void(0)" onclick="event.preventDefault(); location.href='booking.php';">Booking</a></li>
						<li><a class="waves-effect waves-dark" href="javascript:void(0)" onclick="event.preventDefault(); location.href='login.php';">Login</a></li>
					</ul>
				</div>
			</div>
		</div>
	</header>

	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 text-center mb-5">
					<h2 class="heading-section"><strong>Welcome To MMU Hostel</strong></h2>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-12 col-lg-10">
					<div class="wrap d-md-flex">
						<div class="text-wrap p-4 p-lg-5 text-center d-flex align-items-center order-md-last">
							<div class="text w-100">
								<h2>Welcome to login</h2>
								<p>Don't have an account?</p>
								<a href="signup.php" class="btn btn-white btn-outline-white">Student</a>
								<a href="signup2.php" class="btn btn-white btn-outline-white">Lecturer</a>
							</div>
			      </div>
						<div class="login-wrap p-4 p-lg-5">
			      	<div class="d-flex">
			      		<div class="w-100">
			      			<h3 class="mb-4">Sign In</h3>
			      		</div>
								<div class="w-100">
									<p class="social-media d-flex justify-content-end">
										
									</p>
								</div>
			      	</div>
					  <form method="POST" action="login.php">
			      		<div class="form-group mb-3">
			      			<label class="label" for="user_id">UserID</label>
			      			<input type="text" class="form-control" name="user_id" placeholder="UserID" required>

			      		</div>
		            <div class="form-group mb-3">
		            	<label class="label" for="password">Password</label>
						<input type="password" class="form-control" name="password" placeholder="Password" required>

		            </div>
		            <div class="form-group">
		            	<button type="submit" class="form-control btn btn-primary submit px-3">Sign In</button>
		            </div>
		            <div class="form-group d-md-flex">
		            	<div class="w-50 text-left">
			            
									</div>
									<div class="w-50 text-md-right">
										<a href="send-otp_student.php">Forgot Password</a>
									</div>
		            </div>
		          </form>
		        </div>
		      </div>
				</div>
			</div>
		</div>
	</section>

	<?php include('include/footer.php') ?>

	<script src="js/jquery.min.js"></script>
  <script src="js/popper.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>

	</body>
</html>