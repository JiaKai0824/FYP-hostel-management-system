<?php
session_start();
var_dump($password); 
include('includes/config.php');
include('includes/checklogin.php');
check_login();

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = $_POST['password']; 
    
    $status = isset($_POST['status']) ? 1 : 0;
    $superadmin = isset($_POST['superadmin']) ? 1 : 0;
    
    $emailExistsQuery = "SELECT id FROM admin WHERE email = ?";
    $emailExistsStmt = $mysqli->prepare($emailExistsQuery);
    $emailExistsStmt->bind_param('s', $email);
    $emailExistsStmt->execute();
    $emailExistsResult = $emailExistsStmt->get_result();
    
    if ($emailExistsResult->num_rows > 0) {
        echo "<script>alert('Email already exists. Please choose a different email.');</script>";
    } else {
    
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $query = "INSERT INTO admin (username, email, password, reg_date, status, superadmin) VALUES (?, ?, ?, current_timestamp(), ?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('sssii', $username, $email, $hashedPassword, $status, $superadmin);
    $stmt->execute();
  
    echo "<script>alert('New Admin successfully registered');</script>";
}
}



?>

<!doctype html>
<html lang="en" class="no-js">
<head>
	<title>Add New Admin</title>
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">>
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<link rel="stylesheet" href="css/fileinput.min.css">
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<link rel="stylesheet" href="css/style.css">

<script type="text/javascript" src="js/jquery-1.11.3-jquery.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
<script type="text/javascript" src="js/validation.min.js"></script>		
	<script src="js/validation.js"></script>
</head>
<body>
	<?php include('includes/header.php');?>
	<div class="ts-main-content">
	<?php	
    $aid = $_SESSION['id'];
$ret = "SELECT * FROM admin WHERE id=?";
$stmt = $mysqli->prepare($ret);
$stmt->bind_param('i', $aid);
$stmt->execute();
$res = $stmt->get_result();

if ($row = $res->fetch_assoc()) {
    $superadmin = $row['superadmin'];


    if ($superadmin == 1) {
        include('includes/s_sidebar.php');
    } else {
        include('includes/sidebar.php');
    }
}
?>

		<div class="content-wrapper">
			<div class="container-fluid">

				<div class="row">
					<div class="col-md-12">
					
						<h1 class="page-title">Registration For Admin</Form></h1>

						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-primary">
								<div class="panel-heading" style="background-color: #e91e63;">Fill all Info</div>
									<div class="panel-body">
										<form method="post" action="" class="form-horizontal">

<div class="form-group">
<label class="col-sm-2 control-label"><h4 style="color: green" ;align="left">New Admin Info</h4> </label>
</div>


<div class="form-group">
<label class="col-sm-2 control-label">Username:</label>
<div class="col-sm-8">
<input type="text" name="username" id="username" class="form-control" required>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Email:</label>
<div class="col-sm-8">
<input type="email" name="email" id="email "class="form-control" required>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Password:</label>
<div class="col-sm-8">
<input type="password" class="form-control" name="password" id="password" value="" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
</div>
</div>

<style>
.checkbox-left-align .checkbox {
    margin-left: -6cm;
}
</style>

<div class="form-group">
    <label class="col-sm-2 control-label status-label">Status:</label>
    <div class="col-sm-8">
        <input type="checkbox" name="status" id="status" class="form-control" value="1">
    </div>
</div>


<div class="form-group checkbox-left-align">
    <label class="col-sm-2 control-label">Super Admin:</label>
    <div class="col-sm-8">
        <input type="checkbox" name="superadmin" id="superadmin" class="form-control" value="1">
    </div>
</div>


<div class="col-sm-6 col-sm-offset-4">
<button class="btn btn-default" type="submit">Cancel</button>
<input type="submit" name="submit" Value="Register" style="background-color: #e91e63;" class="btn btn-primary">
</div>
</form>

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

    <?php include('includes/footer.php'); ?>
</html>