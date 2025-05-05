<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();
//code for update email id
if (!isset($_SESSION['msg'])) {
    $_SESSION['msg'] = "";
}
if($_POST['update'])
{
$email=$_POST['emailid'];
$aid=$_SESSION['id'];
$udate=date('Y-m-d');
$query="update admin set email=?,updation_date=? where id=?";
$stmt = $mysqli->prepare($query);
$rc=$stmt->bind_param('ssi',$email,$udate,$aid);
$stmt->execute();
echo"<script>alert('Email has been successfully updated');</script>";
}
// code for change password
if (isset($_POST['changepwd'])) {
    $op = $_POST['oldpassword'];
    $np = $_POST['newpassword'];
    $ai = $_SESSION['id'];
    $udate = date('Y-m-d');

    $query = "SELECT password FROM admin WHERE id=?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('i', $ai);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($row = $res->fetch_assoc()) {
        $hashedPassword = $row['password'];

        if (password_verify($op, $hashedPassword)) {
            $newHashedPassword = password_hash($np, PASSWORD_DEFAULT);
            $con = "UPDATE admin SET password=?, updation_date=? WHERE id=?";
            $chngpwd1 = $mysqli->prepare($con);
            $chngpwd1->bind_param('ssi', $newHashedPassword, $udate, $ai);
            $chngpwd1->execute();
            $_SESSION['msg'] = "Password Changed Successfully !!";
        } else {
            if (isset($_SESSION['alert'])) {
                echo htmlentities($_SESSION['alert']);
                echo htmlentities($_SESSION['alert'] = "");
            }
            $_SESSION['alert'] = "Old Password does not match!";
        }
    }
}
?>
<!Doctype html>
<html lang="en" class="no-js">
<head>
	
	<title>Admin Profile</title>
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<link rel="stylesheet" href="css/fileinput.min.css">
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<link rel="stylesheet" href="css/style.css">

	<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
	<script type="text/javascript" src="js/validation.min.js"></script>		
	<script src="js/validation.js"></script>
</head>
<body>

<?php include("includes/header.php");?>

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

					
						<h2 class="page-title">Admin Profile</h2>
	<?php	
	$aid=$_SESSION['id'];
	$ret="select * from admin where id=?";
	$stmt= $mysqli->prepare($ret) ;
	$stmt->bind_param('i',$aid);
	$stmt->execute() ;
	$res=$stmt->get_result();
	 //$cnt=1;
	   while($row=$res->fetch_object())
	  {
	  	?>
						<div class="row">
							<div class="col-md-6">
								<div class="panel panel-default">
									<div class="panel-heading">Admin profile details</div>
									<div class="panel-body">
										<form method="post" class="form-horizontal">
											
											<div class="hr-dashed"></div>
											<div class="form-group">
												<label class="col-sm-2 control-label">Username </label>
												<div class="col-sm-10">
													<input type="text" value="<?php echo $row->username;?>" disabled class="form-control"><span class="help-block m-b-none">
													Username can't be changed.</span> </div>
											</div>
											<div class="form-group">
												<label class="col-sm-2 control-label">Email</label>
												<div class="col-sm-10">
											<input type="email" class="form-control" name="emailid" id="emailid" value="<?php echo $row->email;?>" required="required">
						 
											</div>
											</div>
									<div class="form-group">
									<label class="col-sm-2 control-label">Reg Date</label>
									<div class="col-sm-10">
									<input type="text" class="form-control" value="<?php echo $row->reg_date;?>" disabled >
											</div>
											</div>



												<div class="col-sm-8 col-sm-offset-2">
												<div class="button-container">
													<button class="btn btn-default" type="submit">Cancel</button>
													<input class="btn btn-primary" type="submit" name="update" style="background-color: #e91e63;" value="Update Profile">
												</div>
											</div>
											</div>
										</form>

									</div>
								</div>
									<?php }  ?>


					
								<div class="col-md-6">
								<div class="panel panel-default">
								<div class="panel-heading" >Change Password</div>
								<div class="panel-body">
								<form method="post" class="form-horizontal" name="changepwd" id="change-pwd" onSubmit="return valid();">

 <?php if(isset($_POST['changepwd']))
{ ?>

										<p style="color: green"><?php echo htmlentities($_SESSION['msg']); ?><?php echo htmlentities($_SESSION['msg']=""); ?></p>
										<?php if (isset($_SESSION['alert'])): ?>
                    <p style="color: red"><?php echo htmlentities($_SESSION['alert']); ?></p>
                    <?php unset($_SESSION['alert']); ?>
                    <?php endif; ?>

										<?php } ?>
										<div class="hr-dashed"></div>
										<div class="form-group">
										<label class="col-sm-4 control-label">Old Password </label>
										<div class="col-sm-8">
										<input type="password" value="" name="oldpassword" id="oldpassword" class="form-control" onBlur="checkpass()" required="required">
										<span id="password-availability-status" class="help-block m-b-none" style="font-size:12px;"></span> </div>
										</div>
										<div class="form-group">
										<label class="col-sm-4 control-label">New Password</label>
										<div class="col-sm-8">
												
										<input type="password"  class="form-control" name="newpassword" id="newpassword" value="" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>	
										</div>
								



													<div class="col-sm-6 col-sm-offset-4">
													<div class="button-container">
													<button class="btn btn-default" type="submit">Cancel</button>
													<input type="submit" name="changepwd" style="background-color: #e91e63;" Value="Change Password" class="btn btn-primary">
													
											</div>

										</form>
										
								
							</div>
							</div>
						
									
							

							</div>
						</div>

					</div>
				</div> 	<?php include('includes/footer.php');?>
				

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
	<script>
function checkAvailability() {
$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability.php",
data:'emailid='+$("#emailid").val(),
type: "POST",
success:function(data){
$("#user-availability-status").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}
</script>
<script>
function checkpass() {
$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability.php",
data:'oldpassword='+$("#oldpassword").val(),
type: "POST",
success:function(data){
$("#password-availability-status").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}

                  

  var myInput = document.getElementById("password");
  var letter = document.getElementById("letter");
  var capital = document.getElementById("capital");
  var number = document.getElementById("number");
  var length = document.getElementById("length");
  
  // When the user clicks on the password field, show the message box
  myInput.onfocus = function() {
    document.getElementById("message").style.display = "block";
  }
  
  // When the user clicks outside of the password field, hide the message box
  myInput.onblur = function() {
    document.getElementById("message").style.display = "none";
  }
  
  // When the user starts to type something inside the password field
  myInput.onkeyup = function() {
    // Validate lowercase letters
    var lowerCaseLetters = /[a-z]/g;
    if(myInput.value.match(lowerCaseLetters)) {  
      letter.classList.remove("invalid");
      letter.classList.add("valid");
    } else {
      letter.classList.remove("valid");
      letter.classList.add("invalid");
    }
    
    // Validate capital letters
    var upperCaseLetters = /[A-Z]/g;
    if(myInput.value.match(upperCaseLetters)) {  
      capital.classList.remove("invalid");
      capital.classList.add("valid");
    } else {
      capital.classList.remove("valid");
      capital.classList.add("invalid");
    }
  
    // Validate numbers
    var numbers = /[0-9]/g;
    if(myInput.value.match(numbers)) {  
      number.classList.remove("invalid");
      number.classList.add("valid");
    } else {
      number.classList.remove("valid");
      number.classList.add("invalid");
    }
    
    // Validate length
    if(myInput.value.length >= 8) {
      length.classList.remove("invalid");
      length.classList.add("valid");
    } else {
      length.classList.remove("valid");
      length.classList.add("invalid");
    }
  }

</script>

<style>
	.button-container {
        display: flex;
        justify-content: space-between;
    }
	.button-container .btn {
        width: 150px;
    }
	.button-container .btn-default {
		margin-right: 50px;
  		width: 150px;
	}

input {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  margin-top: 6px;
  margin-bottom: 16px;
}

/* Style the submit button */
input[type=submit] {
  background-color: #04AA6D;
  color: white;
}

/* Style the container for inputs */
.container {
  background-color: #f1f1f1;
  padding: 20px;
}

/* The message box is shown when the user clicks on the password field */
#message {
  display:none;
  background: #f1f1f1;
  color: #000;
  position: relative;
  padding: 20px;
  margin-top: 10px;
}

#message p {
  padding: 10px 35px;
  font-size: 18px;
}
/* Add a green text color and a checkmark when the requirements are right */
.valid {
  color: green;
}

.valid:before {
  position: relative;
  left: -35px;
  content: "✔";
}

/* Add a red text color and an "x" when the requirements are wrong */
.invalid {
  color: red;
}

.invalid:before {
  position: relative;
  left: -35px;
  content: "✖";
}
</style>
<?php include("includes/footer.php");?>
</body>

</html>