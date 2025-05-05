<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();

if(isset($_POST['submit']))
{   $student_id = $_GET['id'];
    $student_name = $_POST['name'];
    $student_email = $_POST['email'];
    $student_password = $_POST['password'];
    $student_phone = $_POST['phone'];
    $student_gender = $_POST['gender'];
    $Emergency_contact_name = $_POST['e_name'];
    $Emergency_contact_phone = $_POST['e_phone'];

	$hashedPassword = password_hash($student_password, PASSWORD_DEFAULT);
    $query = "UPDATE student_information SET student_name=?, student_email=?, student_phone=?, student_gender=?, Emergency_contact_name=?, Emergency_contact_phone=?, student_password=? WHERE student_id=?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('ssissisi', $student_name, $student_email, $student_phone, $student_gender, $Emergency_contact_name, $Emergency_contact_phone, $hashedPassword, $student_id);
    $stmt->execute();
    
	
	echo "<script>alert('Student details updated successfully');</script>";
    header("refresh:1;url=manage-students.php");
}



?>
<!doctype html>
<html lang="en" class="no-js">
<head>
	<title>Edit Student Details</title>
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">>
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<link rel="stylesheet" href="css/fileinput.min.css">
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<link rel="stylesheet" href="css/style.css">
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
					
						<h2 class="page-title">Edit Student Details </h2>
	
						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-default">
									<div class="panel-heading">Edit Student Details</div>
									<div class="panel-body">
										<form method="post" class="form-horizontal">
												<?php	
	$student_id=$_GET['id'];
	$ret="select * from student_information where student_id=?";
	$stmt= $mysqli->prepare($ret) ;
	$stmt->bind_param('i',$student_id);
	$stmt->execute() ;
	$res=$stmt->get_result();

	   while($row=$res->fetch_object())
	  {
	  	?>
	<div class="hr-dashed"></div>
	<div class="form-group">
    <label class="col-sm-2 control-label">Student Name</label>
    <div class="col-sm-8">
    <input type="text" class="form-control" name="name" value="<?php echo $row->student_name;?>">
    </div>
	</div>



	<div class="form-group">
	<label class="col-sm-2 control-label">Phone Number</label>
	<div class="col-sm-8">
	<input type="text" class="form-control" name="phone" id="phone" value="<?php echo $row->student_phone;?>">
	</div>
	</div>

	<div class="form-group">
	<label class="col-sm-2 control-label">Email</label>
	<div class="col-sm-8">
	<input type="text" class="form-control" name="email" value="<?php echo $row->student_email;?>" >
	</div>
	</div>

    <div class="form-group">
	<label class="col-sm-2 control-label">Password</label>
	<div class="col-sm-8">
	<input type="password" class="form-control" name="password" value="" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
	</div>
	</div>

	<div class="form-group">
    <label class="col-sm-2 control-label">Gender</label>
    <div class="col-sm-8">
    <select name="gender" class="form-control" required>
    <option value="Male" <?php if($row->student_gender == 'Male') echo 'selected'; ?>>Male</option>
	<option value="Female" <?php if($row->student_gender == 'Female') echo 'selected'; ?>>Female</option>
	<option value="Others" <?php if($row->student_gender != 'Male' && $row->student_gender != 'Female') echo 'selected'; ?>>Others</option>

	</select>
    </div>
	</div>


	<div class="form-group">
	<label class="col-sm-2 control-label">Emergency Contact Name</label>
	<div class="col-sm-8">
	<input type="text" class="form-control" name="e_name" value="<?php echo $row->Emergency_contact_name;?>" >
	</div>
	</div>

	<div class="form-group">
    <label class="col-sm-2 control-label">Emergency Contact Phone</label>
    <div class="col-sm-8">
	<input type="text" class="form-control" name="e_phone" value="<?php echo $row->Emergency_contact_phone;?>" >
	</div>
	</div>

<?php } ?>
												<div class="col-sm-8 col-sm-offset-2">
													
													<input class="btn btn-primary" type="submit" name="submit" value="Update Student's Details ">
													<a href="manage-students.php"; class="btn btn-default">Back</a>
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