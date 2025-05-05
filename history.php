<?php
include 'dataconnection.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id']; // assuming the user ID is stored in a session variable



$stmt = $connection->prepare("
    SELECT 'student' AS user_type, student_id AS id, student_name AS name, student_email AS email, student_phone AS phone, student_gender AS gender, Emergency_contact_name AS emergency_name, Emergency_contact_phone AS emergency_phone
    FROM student_information 
    WHERE student_id = :user_id1 

    UNION 

    SELECT 'lecturer' AS user_type, lec_id AS id, lec_name AS name, lec_email AS email, lec_phone AS phone, NULL AS gender, NULL AS emergency_name, NULL AS emergency_phone
    FROM lecturer 
    WHERE lec_id = :user_id2");

$stmt->bindValue(':user_id1', $user_id);
$stmt->bindValue(':user_id2', $user_id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$_SESSION['user_type'] = $user['user_type'];



if (!isset($user)) {
    // If user not found in either students or lecturers, redirect back to login
    header("Location: login.php");
    exit();
}

$message = "";
if (isset($_GET['message'])) {
    $message = $_GET['message'];
}

// Fetching booking history for the logged-in user
$history_stmt = $connection->prepare("
SELECT 
b.booking_id, p.payment_date as booking_date, b.start_date, b.end_date,
r.room_type, r.room_number, r.block,
p.payment_method, p.amount, b.status,
GROUP_CONCAT(f.name SEPARATOR ', ') as furniture_names
FROM bookings b
JOIN rooms r ON b.room_id = r.room_id
JOIN payments p ON b.booking_id = p.booking_id
LEFT JOIN furniture_booking fb ON b.booking_id = fb.booking_id
LEFT JOIN furniture f ON fb.furniture_id = f.furniture_id
WHERE b.user_id = :user_id
GROUP BY b.booking_id
ORDER BY p.payment_date DESC

");

$history_stmt->bindValue(':user_id', $user_id);
$history_stmt->execute();
$booking_history = $history_stmt->fetchAll(PDO::FETCH_ASSOC);

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
<a class="nav-link" id="history-tab" href="history.php">
  <i class="fa fa-history text-center mr-1"></i> 
  History
</a>


</div>

				</div>
				<div class="tab-content p-4 p-md-5" id="v-pills-tabContent">
					<div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="account-tab">
						<h3 class="mb-4">Booking History</h3>
						<div class="row">
						<div class="col-md-12">
    <?php foreach ($booking_history as $booking): ?>
        <div class="card my-2">
            <div class="card-body">
                <h5 class="card-title">Booking ID: <?= $booking['booking_id'] ?></h5>
                <p>Booking Date and Time: <?= $booking['booking_date'] ?></p>
                <p>Room Details: <?= $booking['room_type'] . ', Room Number: ' . $booking['room_number'] . ', Block: ' . $booking['block'] ?></p>
                <p>Start Date: <?= $booking['start_date'] ?></p>
                <p>End Date: <?= $booking['end_date'] ?></p>
                <p>Payment Information: <?= $booking['payment_method'] . ', Amount: ' . $booking['amount'] . ', Payment Date: ' . $booking['booking_date'] ?></p>
                <p>Furniture Booked: <?= $booking['furniture_names'] ? $booking['furniture_names'] : 'None' ?></p>
				<p>Booking Status: <?= $booking['status'] ?></p>
				<?php if ($booking['status'] != 'cancelled'): ?>
                    <form method="POST" action="cancel_booking.php" onsubmit="return confirmCancel()">
    <input type="hidden" name="booking_id" value="<?= $booking['booking_id'] ?>"/>
    <button type="submit" class="btn btn-danger">Cancel</button>
</form>
            <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

							

								   
</form>

	</section>

	<?php include('include/footer.php') ?>
    <script>
function confirmCancel() {
    return confirm("Are you sure you want to cancel this booking?");
}
</script>

	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>



</body>
</html>