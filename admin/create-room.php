<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();
//code for add courses
if(isset($_POST['submit']))
{
    $room_type = $_POST['seater'];
    $room_number = $_POST['rmno'];
    $price = $_POST['fee'];
    $block = $_POST['block'];
    $max_capacity = $_POST['max'];
    $is_available = $_POST['available'];

    // Check if the room number already exists in the selected block
    $query_check = "SELECT room_number FROM rooms WHERE block=?";
    $stmt_check = $mysqli->prepare($query_check);
    $stmt_check->bind_param('s', $block);
    $stmt_check->execute();
    $stmt_check->store_result();
    $row_count = $stmt_check->num_rows;

  
        $query = "INSERT INTO rooms (room_type, room_number, price, block, max_capacity, is_available) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('iiisii', $room_type, $room_number, $price, $block, $max_capacity, $is_available);
        $stmt->execute();
        echo "<script>alert('Room has been added successfully');</script>";
 
}
?>
<!doctype html>
<html lang="en" class="no-js">
<head>

	<title>Create Room</title>
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

			
					<div class="col-md-12">
					
						<h1 class="page-title">Add a Room </h1>
	
						
							<div class="col-md-12">
								<div class="panel panel-default">
									<div class="panel-heading">Add a Room</div>
									<div class="panel-body">
									<?php if(isset($_POST['submit']))
 ?>

<form method="post" class="form-horizontal">
											
											
<div class="form-group">
<label class="col-sm-2 control-label">Select Room Type</label>
<div class="col-sm-8">
<Select name="seater" class="form-control" required>
<option value="">Select Room</option>
<option value="1">Single Room</option>
<option value="2">Double Room</option>
</Select>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Select Block</label>
<div class="col-sm-8">
<Select name="block" class="form-control" required>
<option value="">Select Block</option>
<option value="A">A</option>
<option value="B">B</option>
<option value="C">C</option>
<option value="D">D</option>
</Select>
</div>
</div>
<p>

<div class="form-group">
<label class="col-sm-2 control-label">Maximum Capacity</label>
<div class="col-sm-8">
<Select name="max" class="form-control" required>
<option value="">Select Max</option>
<option value="1">1</option>
<option value="2">2</option>
</Select>
</div>
</div> 	
<div class="form-group">
<label class="col-sm-2 control-label">Room No.</label>
<div class="col-sm-8">
<input type="text" class="form-control" name="rmno" id="rmno" value="" required="required">
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Fee(Per Student)</label>
<div class="col-sm-8">
<input type="text" class="form-control" name="fee" id="fee" value="" required="required">
</div>
</div>

<div class="col-sm-8 col-sm-offset-2">
<input class="btn btn-primary" type="submit" name="submit" style="background-color: #e91e63;" value="Create Room ">
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