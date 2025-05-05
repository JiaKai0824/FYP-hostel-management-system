<?php
session_start();
include 'dataconnection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if(isset($_POST['submit'])){
    $oldPassword = $_POST['oldPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmNewPassword = $_POST['confirmNewPassword'];

    // Check if the old password matches the user's current password
    $stmt = $connection->prepare("SELECT 'student_information' AS user_type, student_password AS password_hash FROM student_information WHERE student_id = :user_id1 UNION SELECT 'lecturer' AS user_type, lec_password AS password_hash FROM lecturer WHERE lec_id = :user_id2");
    $stmt->bindValue(':user_id1', $user_id);
    $stmt->bindValue(':user_id2', $user_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (password_verify($oldPassword, $result['password_hash'])) {

    // Validate new password complexity
    if (preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/', $newPassword)) {

        if($newPassword == $confirmNewPassword){
            // Update the user's password in the database
            $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
            $id_column = ($result['user_type'] == 'student_information') ? "student_id" : "lec_id";
            $password_column = ($result['user_type'] == 'student_information') ? "student_password" : "lec_password";
            $stmt = $connection->prepare("UPDATE {$result['user_type']} SET $password_column = :password WHERE $id_column = :user_id");
            $stmt->bindValue(':password', $newPasswordHash);
            $stmt->bindValue(':user_id', $user_id);
            $success = $stmt->execute();

            if ($success) {
                $_SESSION['message'] = 'Password has been successfully changed';
            } else {
                $_SESSION['message'] = 'Error updating password: ' . $stmt->errorInfo()[2];
            }
        } else {
            $_SESSION['message'] = "New password and confirm new password do not match.";
        }
    } else {
        $_SESSION['message'] = "New password does not meet complexity requirements.";
    }
} else {
    $_SESSION['message'] = "Old password does not match.";
}

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
        .eye-icon:hover {
    cursor: pointer;
}

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
<div class="tab-content p-4 p-md-5" id="v-pills-tabContent">
    <div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="account-tab">
        <h3 class="mb-4">Change Password</h3>
        <?php if(isset($error_message)){ ?>
            <p><?php echo $error_message; ?></p>
        <?php } ?>
        <form method="post">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
    <label>Old password</label>
    <div class="input-group">
        <input type="password" class="form-control" id="oldPassword" name="oldPassword">
        <div class="input-group-append">
        <i class="fa fa-eye eye-icon" id="toggleOldPassword" onclick="togglePasswordVisibility('oldPassword', 'toggleOldPassword')"></i>
        </div>
    </div>
</div>
                </div>
                <div class="col-md-6">  
                <div class="form-group">
    <label>New password</label>
    <div class="input-group">
        <input type="password" class="form-control" id="newPassword" name="newPassword">
        <div class="input-group-append">
        <i class="fa fa-eye eye-icon" id="toggleNewPassword" onclick="togglePasswordVisibility('newPassword', 'toggleNewPassword')"></i>
        </div>
    </div>
</div>
                </div>
                <div class="col-md-6">
                <div class="form-group">
    <label>Confirm new password:</label>
    <div class="input-group">
        <input type="password" class="form-control" id="confirmNewPassword" name="confirmNewPassword">
        <div class="input-group-append">
        <i class="fa fa-eye eye-icon" id="toggleConfirmNewPassword" onclick="togglePasswordVisibility('confirmNewPassword', 'toggleConfirmNewPassword')"></i>
        </div>
    </div>
</div>
                </div>
                <div class="col-md-12"> <!-- Added a new column to hold the buttons -->
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit" name="submit" value="Submit">Submit</button>
                        <button class="btn btn-light" onclick="location.href='userprofile.php'">Cancel</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

</form>

	</section>

	<?php include('include/footer.php') ?>

    <script type="text/javascript">
    var message = "<?php echo addslashes($_SESSION['message'] ?? ''); ?>";
    if (message !== "") {
        alert(message);
        <?php unset($_SESSION['message']); ?> // remove the message from the session after displaying it
    }
</script>
<script>
function togglePasswordVisibility(passwordFieldId, iconId) {
    var passwordField = document.getElementById(passwordFieldId);
    var toggleIcon = document.getElementById(iconId);
    
    if (passwordField.type === "password") {
        passwordField.type = "text";
        toggleIcon.classList.remove("fa-eye"); // remove eye icon
        toggleIcon.classList.add("fa-eye-slash"); // add eye-slash icon
    } else {
        passwordField.type = "password";
        toggleIcon.classList.remove("fa-eye-slash"); // remove eye-slash icon
        toggleIcon.classList.add("fa-eye"); // add eye icon
    }
}
</script>


	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>


</body>
</html>
