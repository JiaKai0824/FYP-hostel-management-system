<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();

if(isset($_POST['submit']))
{   $lec_id = $_GET['lec_id'];
    $lec_name = $_POST['name'];
    $lec_email = $_POST['email'];
    $lec_password = $_POST['password'];
    $lec_phone = $_POST['phone'];

	$hashedPassword = password_hash($lec_password, PASSWORD_DEFAULT);
    $query = "UPDATE lecturer SET lec_name=?, lec_email=?, lec_phone=?, lec_password=? WHERE lec_id=?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('ssisi', $lec_name, $lec_email, $lec_phone, $hashedPassword, $lec_id);
    $stmt->execute();

	
	echo "<script>alert('Lecturer details updated successfully');</script>";

    header("refresh:1;url=manage-lecturer.php");
}



?>
<!doctype html>
<html lang="en" class="no-js">
<head>
	<title>Edit Lecturer Details</title>
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">>
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<link rel="stylesheet" href="css/fileinput.min.css">
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<link rel="stylesheet" href="css/style.css">
	<link href="css2/style.css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery-1.11.3-jquery.min.js"></script>
<script type="text/javascript" src="js/validation.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
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

    // Include the appropriate sidebar file based on superadmin value
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
					
						<h2 class="page-title">Edit Lecturer Details </h2>
	
						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-default">
									<div class="panel-heading">Edit Lecturer Details</div>
									<div class="panel-body">
										<form method="post" class="form-horizontal">
												<?php	
	$lec_id=$_GET['lec_id'];
	$ret="select * from lecturer where lec_id=?";
	$stmt= $mysqli->prepare($ret) ;
	$stmt->bind_param('s',$lec_id);
	$stmt->execute() ;//ok
	$res=$stmt->get_result();
	 //$cnt=1;
	   while($row=$res->fetch_object())
	  {
	  	?>
	<div class="hr-dashed"></div>
	<div class="form-group">
    <label class="col-sm-2 control-label">Lecturer Name</label>
    <div class="col-sm-8">
    <input type="text" class="form-control" name="name" value="<?php echo $row->lec_name;?>">
    </div>
	</div>

	<div class="form-group">
    <label class="col-sm-2 control-label">Phone Number</label>
    <div class="col-sm-8">
    <input type="text" class="form-control" name="phone" id="phone" value="<?php echo $row->lec_phone;?>">
    </div>
	</div>


	<div class="form-group">
	<label class="col-sm-2 control-label">Email</label>
	<div class="col-sm-8">
	<input type="text" class="form-control" name="email" value="<?php echo $row->lec_email;?>" >
	</div>
	</div>

    <div class="form-group">
	<label class="col-sm-2 control-label">Password</label>
	<div class="col-sm-8">
	<input type="password" class="form-control" name="password" value="" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
	</div>
	</div>


<?php } ?>
												<div class="col-sm-8 col-sm-offset-2">
													
													<input class="btn btn-primary" type="submit" name="submit" value="Update Lecturer's Details ">
													<a href="manage-lecturer.php"; class="btn btn-default">Back</a>
												</div>
											</div>

										</form>

									</div>
								</div>
							</div>
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

</script>
</body>
<?php include('includes/footer.php'); ?>
</html>