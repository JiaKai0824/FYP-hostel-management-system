<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();

// Code for registration
if (isset($_POST['submit'])) {
    $student_name = $_POST['student_name'];
    $student_gender = $_POST['student_gender'];
    $student_phone = $_POST['contact'];
    $student_email = $_POST['email'];
    $student_password = isset($_POST['password']) ? $_POST['password'] : '';
    $student_id = $_POST['id'];
    $Emergency_contact_name = $_POST['ename'];
    $Emergency_contact_phone = $_POST['econtact'];

    // Check if the student ID already exists in the database
    $checkIDQuery = "SELECT COUNT(*) AS count FROM student_information WHERE student_id = ?";
    $stmt = $mysqli->prepare($checkIDQuery);
    $stmt->bind_param('s', $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $idCount = $result->fetch_assoc()['count'];

    if ($idCount > 0) {
        echo "<script>alert('Student ID already exists. Please use a different student ID.');</script>";
    } else {
        // Check if the email address already exists in the database
        $checkEmailQuery = "SELECT COUNT(*) AS count FROM student_information WHERE student_email = ?";
        $stmt = $mysqli->prepare($checkEmailQuery);
        $stmt->bind_param('s', $student_email);
        $stmt->execute();
        $result = $stmt->get_result();
        $emailCount = $result->fetch_assoc()['count'];

        if ($emailCount > 0) {
            echo "<script>alert('Email address already exists. Please use a different email address.');</script>";
        } else {
            // All checks passed, insert the student information into the database
            $hashedPassword = password_hash($student_password, PASSWORD_DEFAULT);
            $query = "INSERT INTO student_information (student_id, student_name, student_email, student_password, student_phone, student_gender, Emergency_contact_name, Emergency_contact_phone) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param('isssissi', $student_id, $student_name, $student_email, $hashedPassword, $student_phone, $student_gender, $Emergency_contact_name, $Emergency_contact_phone);
            $stmt->execute();
            $student_info_id = $mysqli->insert_id;

            echo "<script>alert('Student successfully registered');</script>";
        }
    }
}
?>


<!doctype html>
<html lang="en" class="no-js">
<head>
	<title>Student Hostel Registration</title>
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
					
						<h1 class="page-title">Registration Student </h1>

						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-primary">
									<div class="panel-heading" style="background-color: #e91e63;">Fill all Info</div>
									<div class="panel-body">
										<form method="post" action="" class="form-horizontal">
											
										


<div class="form-group">
<label class="col-sm-2 control-label"><h4 style="color: green" ;align="left">Personal info </h4> </label>
</div>


<div class="form-group">
<label class="col-sm-2 control-label">Student ID : </label>
<div class="col-sm-8">
<input type="text" name="id" id="id"  class="form-control" required="required" >
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Student Name : </label>
<div class="col-sm-8">
<input type="text" name="student_name" id="student_name"  class="form-control" required="required" >
</div>
</div>


<div class="form-group">
<label class="col-sm-2 control-label">Gender : </label>
<div class="col-sm-8">
<select name="student_gender" class="form-control" required="required">
<option value="">Select Gender</option>
<option value="male">Male</option>
<option value="female">Female</option>
<option value="others">Others</option>
</select>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Phone Number: </label>
<div class="col-sm-8">
<input type="text" name="contact" id="contact"  class="form-control" required="required">
</div>
</div>


<div class="form-group">
<label class="col-sm-2 control-label">Student Email : </label>
<div class="col-sm-8">
<input type="text" name="email" id="email" class="form-control" required="required">
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Create a Password: </label>
<div class="col-sm-8">
<input type="text" class="form-control" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Guardian Name : </label>
<div class="col-sm-8">
<input type="text" name="ename" id="ename"  class="form-control" required="required">
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Emergency Contact: </label>
<div class="col-sm-8">
<input type="text" name="econtact" id="econtact"  class="form-control" required="required">
</div>
</div>

						


<div class="col-sm-6 col-sm-offset-4">
<button class="btn btn-default" type="submit">Cancel</button>
<input type="submit" name="submit" style="background-color: #e91e63;" Value="Register" class="btn btn-primary">
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
<?php include('includes/footer.php'); ?>
<script type="text/javascript">
	$(document).ready(function(){
        $('input[type="checkbox"]').click(function(){
            if($(this).prop("checked") == true){
                $('#paddress').val( $('#address').val() );
                $('#pcity').val( $('#city').val() );
                $('#pstate').val( $('#state').val() );
                $('#ppincode').val( $('#pincode').val() );
            } 
            
        });
    });
</script>
	<script>
function checkAvailability() {
$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability.php",
data:'room_number='+$("#room").val(),
type: "POST",
success:function(data){
$("#room-availability-status").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}
</script>

</html>