<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();
//code for registration
if (isset($_POST['submit'])) {
    $lec_name = $_POST['lec_name'];
    $lec_phone = $_POST['contact'];
    $lec_email = $_POST['email'];
    $lec_password = isset($_POST['password']) ? $_POST['password'] : '';
    $lec_id = $_POST['id'];

    // Check if the lecturer ID already exists in the database
    $checkIDQuery = "SELECT * FROM lecturer WHERE lec_id = ?";
    $stmt = $mysqli->prepare($checkIDQuery);
    $stmt->bind_param('s', $lec_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Lecturer ID already exists. Please choose a different ID.');</script>";
    } else {
        // Check if the email address already exists in the database
        $checkEmailQuery = "SELECT * FROM lecturer WHERE lec_email = ?";
        $stmt = $mysqli->prepare($checkEmailQuery);
        $stmt->bind_param('s', $lec_email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('Email address already exists. Please use a different email address.');</script>";
        } else {
            $hashedPassword = password_hash($lec_password, PASSWORD_DEFAULT);
            $query = "INSERT INTO lecturer (lec_id, lec_name, lec_email, lec_password, lec_phone) VALUES (?, ?, ?, ?, ?)";
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param('ssssi', $lec_id, $lec_name, $lec_email, $hashedPassword, $lec_phone);
            $stmt->execute();
            $lec_info_id = $stmt->insert_id;

            echo "<script>alert('New Lecturer Successfully registered');</script>";
        }
    }
}
?>


<!doctype html>
<html lang="en" class="no-js">
<head>
	<title>Lecturer Hostel Registration</title>
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
					
						<h1 class="page-title">Registration For Lecturer</Form></h1>

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
<label class="col-sm-2 control-label">Lecturer ID : </label>
<div class="col-sm-8">
<input type="text" name="id" id="id"  class="form-control" required="required" >
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Lecturer Name : </label>
<div class="col-sm-8">
<input type="text" name="lec_name" id="lec_name"  class="form-control" required="required" >
</div>
</div>


<div class="form-group">
<label class="col-sm-2 control-label">Phone Number: </label>
<div class="col-sm-8">
<input type="text" name="contact" id="contact"  class="form-control" required="required">
</div>
</div>


<div class="form-group">
<label class="col-sm-2 control-label">Lecturer Email : </label>
<div class="col-sm-8">
<input type="text" name="email" id="email" class="form-control" required="required">
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Create a Password</label>
<div class="col-sm-8">
<input type="text" class="form-control" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
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
<?php include('includes/footer.php'); ?>
</html>