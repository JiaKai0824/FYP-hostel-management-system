<?php
include 'dataconnection.php';

// Define the function to fetch user data
function fetch_user_data($user_id) {
    global $connection;  // to use the PDO instance in the function

    $stmt = $connection->prepare("
        SELECT 'student' AS user_type, student_id AS id, student_name AS name, student_email AS email, student_phone AS phone, student_gender AS gender, Emergency_contact_name AS emergency_name, Emergency_contact_phone AS emergency_phone
        FROM student_information 
        WHERE student_id = :user_id1 

        UNION 

        SELECT 'lecturer' AS user_type, lec_id AS id, lec_name AS name, lec_email AS email, lec_phone AS phone, NULL AS gender, NULL AS emergency_name, NULL AS emergency_phone
        FROM lecturer 
        WHERE lec_id = :user_id2");

    $stmt->bindValue(':user_id1', $user_id);
    $stmt->bindValue(':user_id2', $user_id);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id']; // assuming the user ID is stored in a session variable
$user = fetch_user_data($user_id); // fetch the user data
$_SESSION['user_type'] = $user['user_type'];
$errors = [];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format';
    }

    if (!ctype_digit($_POST['phone']) || (strlen($_POST['phone']) != 10 && strlen($_POST['phone']) != 11)) {
        $errors['phone'] = 'Phone number must be 10 or 11 digits';
    }

    if (!ctype_digit($_POST['Emergency_contact_phone']) || (strlen($_POST['Emergency_contact_phone']) != 10 && strlen($_POST['Emergency_contact_phone']) != 11)) {
        $errors['Emergency_contact_phone'] = 'Emergency contact phone number must be 10 or 11 digits';
    }

    // If no errors, proceed with updating the data in the database
    if (empty($errors)) {
        if ($user['user_type'] == 'student') {
            $stmt = $connection->prepare("
                UPDATE student_information 
                SET student_email = :email, student_phone = :phone, Emergency_contact_name = :emergency_name, Emergency_contact_phone = :emergency_phone
                WHERE student_id = :user_id
            ");
        } else if ($user['user_type'] == 'lecturer') {
            $stmt = $connection->prepare("
                UPDATE lecturer 
                SET lec_email = :email, lec_phone = :phone
                WHERE lec_id = :user_id
            ");
        }
    
        $stmt->bindValue(':email', $_POST['email']);
        $stmt->bindValue(':phone', $_POST['phone']);
        if ($user['user_type'] == 'student') {
            $stmt->bindValue(':emergency_name', $_POST['Emergency_contact_name']);
            $stmt->bindValue(':emergency_phone', $_POST['Emergency_contact_phone']);
        }
        $stmt->bindValue(':user_id', $user_id);
        $success = $stmt->execute();
    
        if ($success) {
            $_SESSION['message'] = 'Update was successful';
        } else {
            $_SESSION['message'] = 'Update failed';
        }
    
        // Fetch the updated user data
        $user = fetch_user_data($user_id);
    }
}


if (!isset($user)) {
    // If user not found in either students or lecturers, redirect back to login
    header("Location: login.php");
    exit();
}

$message = "";
if (isset($_GET['message'])) {
    $message = $_GET['message'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>User Profile Settings</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/style2.css">
	<link href="css2/style.css" rel="stylesheet" />
	<style>
.navbar-brand {
    display: inline-block;
    margin-top: -30px;
    margin-left: -35px;
    padding: 0 15px;
    color: #e91e63;
    text-transform: uppercase;
    font-size: 24px;
    font-weight: 700;
    line-height: 1em;
    letter-spacing: -1px;
    text-decoration: none !important;
}

.nav.navbar-nav {
    float: right;
    margin-top: 25px;
    margin-bottom: 0;
}

.navbar-nav > li {
    margin-right: 10px;
}

.navbar-nav > li > a {
    padding: 15px 10px;
    line-height: 1em;
    font-weight: 700;
    color: #9a9a9a;
    text-transform: uppercase;
	text-decoration: none !important;
}

.navbar-nav > li > a:hover {
    color: white;
    background-color: #222;
}

.navbar-nav > .active > a,
.navbar-nav > .active > a:hover,
.navbar-nav > .active > a:focus {
    color: #e91e63;
    background-color: #e91e63 !important;
}

.navbar-header {
    padding: 20px;
    background-size: cover;
    background-position: center;
    background-image: url('path/to/your/image.jpg');
}
</style>
</head>
<body>
<header>
    <div class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="home.php"><i class="icon-info-blocks material-icons"></i> MMU Hostel</a>
            </div>

            <ul class="nav navbar-nav" style="margin-top: -58px;">
                <li class="HillSide"><a class="waves-effect waves-dark" href="home.php">&nbsp;Home&nbsp;</a></li> 
                <li><a class="waves-effect waves-dark" href="portfolio.php">&nbsp;Gallery&nbsp;</a></li>
                <li><a class="waves-effect waves-dark" href="aboutus.php">&nbsp;Contact&nbsp;</a></li>
                <li><a class="waves-effect waves-dark" href="booking.php">&nbsp;Booking&nbsp;</a></li>
            <?php 
            if(isset($_SESSION['user_id'])) {
                echo '<ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle waves-effect waves-dark" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="margin-top: -39px;">'.$_SESSION['user_id'].'<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="userprofile.php">User Profile</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="logout.php">Logout</a></li>
                            </ul>
                        </li>
                    </ul>';
            } else {
                echo '<ul class="nav navbar-nav navbar-right">
                        <li><a class="waves-effect waves-dark" href="login.php">Login</a></li>
                    </ul>';
            }
            ?>
            </ul>
        </div>
    </div>
</header>

	<section class="py-5 my-5">
		<div class="container">
			<h1 class="mb-5">User Profile</h1>
			<div class="bg-white shadow rounded-lg d-block d-sm-flex">
				<div class="profile-tab-nav border-right">
					<div class="p-4">
						<div class="img-circle text-center mb-3">
							<img src="img/avatar.png" alt="Image" class="shadow">
						</div>
					
					</div>
					<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
						<a class="nav-link" id="account-tab" href="userprofile.php">
							<i class="fa fa-home text-center mr-1"></i> 
							Account	
						</a>
						<a class="nav-link" id="password-tab" href="updatepassword.php">
							<i class="fa fa-key text-center mr-1"></i> 
							Password
						</a>
						<a class="nav-link" id="password-tab" href="history.php">
							<i class="fa fa-key text-center mr-1"></i> 
							History
						</a>
					</div>
				</div>
				<form method="POST" action="userprofile.php">
				<div class="tab-content p-4 p-md-5" id="v-pills-tabContent">
					<div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="account-tab">
						<h3 class="mb-4">Profile Settings</h3>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Name</label>
									<input type="text" class="form-control" name="name" value="<?php echo $user['name']; ?>" readonly>
								</div>
								<div class="form-group">
									<label>Email</label>
									<input type="email" class="form-control" name="email" value="<?php echo $user['email']; ?>">
									<?php if (isset($_SESSION['errors']['email'])): ?>
										<p class="text-danger"><?php echo $_SESSION['errors']['email']; ?></p>
										<?php unset($_SESSION['errors']['email']); ?>
									<?php endif; ?>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
								  	<label>ID</label>
								  	<input type="text" class="form-control" name="id" value="<?php echo $user['id']; ?>" readonly>
								</div>
								<div class="form-group">
									<label>Phone</label>
									<input type="text" class="form-control" name="phone" value="<?php echo $user['phone']; ?>">
									<?php if (isset($_SESSION['errors']['phone'])): ?>
										<p class="text-danger"><?php echo $_SESSION['errors']['hone']; ?></p>
										<?php unset($_SESSION['errors']['phone']); ?>
									<?php endif; ?>
								</div>
							</div>
							<?php if ($user['user_type'] == 'student'): ?>
								<div class="col-md-6">
									<div class="form-group">
									  	<label>Gender</label>
									  	<input type="text" class="form-control" name="student_gender" value="<?php echo $user['gender']; ?>" readonly>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Emergency contact name</label>
										<input type="text" class="form-control" name="Emergency_contact_name" value="<?php echo $user['emergency_name']; ?>">
									</div>
									<div class="form-group">
										<label>Emergency contact phone</label>
										<input type="text" class="form-control" name="Emergency_contact_phone" value="<?php echo $user['emergency_phone']; ?>">
										<?php if (isset($_SESSION['errors']['Emergency_contact_phone'])): ?>
											<p class="text-danger"><?php echo $_SESSION['errors']['Emergency_contact_phone']; ?></p>
											<?php unset($_SESSION['errors']['Emergency_contact_phone']); ?>
										<?php endif; ?>
									</div>
								</div>
							<?php endif; ?>
						</div>
						<div>
							<button class="btn btn-primary">Update</button>
							<button class="btn btn-light">Cancel</button>
						</div>
					</div>
				</div>
				</form>
			</div>
		</div>
		
	</section>

	<?php include('include/footer.php') ?>

    <script type="text/javascript">
    var message = "<?php echo addslashes($_SESSION['message'] ?? ''); ?>";
    if (message !== "") {
        alert(message);
        <?php unset($_SESSION['message']); ?> // remove the message from the session after displaying it
    }
</script>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script type="text/javascript">
    var message = "<?php echo addslashes($message); ?>";
    if (message !== "") {
        alert(message);
    }
</script>



</body>
</html>

