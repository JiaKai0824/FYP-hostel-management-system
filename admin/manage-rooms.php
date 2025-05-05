<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();

if(isset($_GET['del']))
{
	$room_id=intval($_GET['del']);
	$adn="delete from rooms where room_id=?";
	$stmt= $mysqli->prepare($adn);
	$stmt->bind_param('i',$room_id);
    $stmt->execute();
    $stmt->close();	   
    echo "<script>alert('Data Deleted');</script>" ;
}
?>
<!doctype html>
<html lang="en" class="no-js">

<head>
	<title>Manage Rooms</title>
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<link rel="stylesheet" href="css/fileinput.min.css">
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<link rel="stylesheet" href="css/style.css">
	<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
	<style>
    .page-title {
        margin-top: 50px;
    }
	</style>
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
						<h1 class="page-title"><br>Manage Rooms</h1>
						<div class="panel panel-default">
							<div class="panel-heading">All Room Details</div>
							<div class="panel-body">
								<table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>No.</th>
											<th>Type</th>
											<th>Room No.</th>
											<th>Fees (RM) </th>
											<th>Block</th>
											<th>Maximum Capacity</th>
											<th>Current Capacity</th>
											<th>Availability</th>
											<th>Action</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
											<th>No.</th>
											<th>Type</th>
											<th>Room No.</th>
											<th>Fees (RM) </th>
											<th>Block</th>
											<th>Maximum Capacity</th>
											<th>Current Capacity</th>
											<th>Availability</th>
											<th>Action</th>
										</tr>
									</tfoot>
									<tbody>
									<?php	
$aid = $_SESSION['id'];
$ret = "SELECT * FROM rooms ORDER BY block ASC";
$stmt = $mysqli->prepare($ret);
$stmt->execute();
$res = $stmt->get_result();
$cnt = 1;
while ($row = $res->fetch_object()) {
	?>
	<tr>
		<td><?php echo $cnt; ?></td>
		<td><?php echo $row->room_type; ?></td>
		<td><?php echo $row->room_number; ?></td>
		<td><?php echo $row->price; ?></td>
		<td><?php echo $row->block; ?></td>
		<td><?php echo $row->max_capacity; ?></td>
		<td><?php echo $row->current_capacity; ?></td>
		<td><?php echo $row->is_available; ?></td>
		<td>
			<a href="edit-room.php?id=<?php echo $row->room_id; ?>"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
			<a href="manage-rooms.php?del=<?php echo $row->room_id; ?>" onclick="return confirm('Do you want to delete?')"><i class="fa fa-close"></i></a>
		</td>
	</tr>
	<?php
	$cnt = $cnt + 1;
}
?>

										
									</tbody>
								</table>

								
							</div>
						</div>

					
					</div>
				</div>

			

			</div>
		</div>
	</div>

	<!-- Loading Scripts -->
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
