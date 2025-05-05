<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();

if(isset($_POST['submit']))
{
    $room_type = $_POST['seater'];
    $price = $_POST['fees'];
    $room_id = $_GET['id'];
    $room_number = $_POST['rmno'];
    $block = $_POST['block'];
    $max_capacity = $_POST['max'];
    $current_capacity = $_POST['current'];
    $is_available = $_POST['available'];

    $query = "UPDATE rooms SET room_type=?, price=?, room_number=?, block=?, max_capacity=?, current_capacity=?, is_available=? WHERE room_id=?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('siisiiii', $room_type, $price, $room_number, $block, $max_capacity, $current_capacity, $is_available, $room_id);
    $stmt->execute();
    
    echo "<script>alert('Room Details have been updated successfully');</script>";
	echo "<script>window.location.href = 'manage-rooms.php';</script>";
}



?>
<!doctype html>
<html lang="en" class="no-js">
<head>
	<title>Edit Room Details</title>
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
					
						<h2 class="page-title">Edit Room Details </h2>
	
						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-default">
									<div class="panel-heading">Edit Room Details</div>
									<div class="panel-body">
										<form method="post" class="form-horizontal">
												<?php	
												$room_id=$_GET['id'];
	$ret="select * from rooms where room_id=?";
	$stmt= $mysqli->prepare($ret) ;
	$stmt->bind_param('i',$room_id);
	 $stmt->execute() ;//ok
	 $res=$stmt->get_result();
	 //$cnt=1;
	   while($row=$res->fetch_object())
	  {
	  	?>
	<div class="hr-dashed"></div>
	<div class="form-group">
    <label class="col-sm-2 control-label">Room Type</label>
    <div class="col-sm-8">
    <select name="seater" class="form-control" required>
    <option value="<?php echo $row->room_type;?>"><?php echo $row->room_type;?></option>
    <?php if($row->room_type == 'single'): ?>
        <option value="2">double</option>
    <?php elseif($row->room_type == 'double'): ?>
        <option value="1">single</option>
    <?php endif; ?>
    </select>
    </div>
	</div>



	<div class="form-group">
	<label class="col-sm-2 control-label">Room no </label>
	<div class="col-sm-8">
	<input type="text" class="form-control" name="rmno" id="rmno" value="<?php echo $row->room_number;?>"disable>

	</div>
	</div>

	<div class="form-group">
	<label class="col-sm-2 control-label">Fees (PM) </label>
	<div class="col-sm-8">
	<input type="text" class="form-control" name="fees" value="<?php echo $row->price;?>" >
	</div>
	</div>

	<div class="form-group">
    <label class="col-sm-2 control-label">Block</label>
    <div class="col-sm-8">
	<select name="block" class="form-control" required>
        <option value="<?php echo $row->block;?>"><?php echo $row->block;?></option>
        <?php if($row->block == 'A'): ?>
            <option value="B">B</option>
            <option value="C">C</option>
            <option value="D">D</option>
        <?php elseif($row->block == 'B'): ?>
            <option value="A">A</option>
            <option value="C">C</option>
            <option value="D">D</option>
        <?php elseif($row->block == 'C'): ?>
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="D">D</option>
        <?php elseif($row->block == 'D'): ?>
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="C">C</option>
        <?php endif; ?>
    </select>
    </div>
	</div>

	<div class="form-group">
	<label class="col-sm-2 control-label">Maximum Capacity</label>
	<div class="col-sm-8">
	<input type="text" class="form-control" name="max" value="<?php echo $row->max_capacity;?>" >
	</div>
	</div>

	<div class="form-group">
	<label class="col-sm-2 control-label">Current Capacity</label>
	<div class="col-sm-8">
	<input type="text" class="form-control" name="current" value="<?php echo $row->current_capacity;?>" >
	</div>
	</div>
	
	<div class="form-group">
    <label class="col-sm-2 control-label">Availability</label>
    <div class="col-sm-8">
        <?php
            $isAvailable = '';
            if ($row->current_capacity == $row->$max_capacity) {
                $isAvailable = 0;
                $label = "Full";
            } else {
                $isAvailable = 1;
                $label = "Available";
            }
        ?>
        <input type="text" class="form-control" value="<?php echo $label;?>" readonly>
        <input type="hidden" name="available" value="<?php echo $isAvailable;?>">
    </div>
</div>



<?php } ?>
												<div class="col-sm-8 col-sm-offset-2">
													
													<input class="btn btn-primary" type="submit" name="submit" value="Update Room Details ">
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