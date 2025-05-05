<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="" />
	<meta name="author" content="http://code4berry.com" />
	<!-- css --> 
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="materialize/css/materialize.min.css" media="screen,projection" />
	<link href="css2/bootstrap.min.css" rel="stylesheet" />
	<link href="css2/fancybox/jquery.fancybox.css" rel="stylesheet"> 
	<link href="css2/flexslider.css" rel="stylesheet" /> 
	<link rel="stylesheet" type="text/css" href="css2/zoomslider.css" />
	<link href="css2/style.css" rel="stylesheet" />
    <title>Booking Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f1f1;
        }
        h1 {
        text-align: center;
        margin-top: 50px;
    }

    .confirmation-details {
        margin: 20px auto;
        width: 500px;
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .confirmation-details h2 {
        margin-top: 0;
        color: #333;
    }

    .confirmation-details p {
        margin: 10px 0;
        color: #555;
    }

    .button-container {
        text-align: center;
        margin-top: 20px;
    }

    .button-container button {
        margin: 0 5px;
        background-color: #e91e63;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
        transition: background-color 0.3s ease;
    }

    .button-container button:hover {
        background-color: #c2185b;
    }
</style>
</head>
<body>

<?php session_start();
include('include/header.php') ?>

<h1>Booking Confirmation</h1>
<div class="confirmation-details">
    <?php
    include 'dataconnection.php';
    
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }

    if (!isset($_SESSION['booking_details'])) {
        header('Location: booking.php');
        exit();
    }

    if (isset($_POST['selected_furniture'])) {
        $_SESSION['booking_details']['selected_furniture'] = $_POST['selected_furniture'];
    }

    $roomType = $_SESSION['booking_details']['room_type'];

    // Fetch the room details based on the room id stored in the session
    $sql = "SELECT room_id, room_number, price FROM rooms WHERE room_id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bindValue(1, $_SESSION['room_id']);
    $stmt->execute();
    $row = $stmt->fetch();
    $room_id = $row['room_id'];
    $room_number = $row['room_number'];
    $roomPrice = $row['price'];

    // Update the room_id session variable
    $_SESSION['room_id'] = $room_id;

    $totalFurniturePrice = 0;
    $selected_furniture_names = [];

    $selected_furniture = $_SESSION['booking_details']['selected_furniture'] ?? [];

    if (!empty($selected_furniture)) {
        foreach ($selected_furniture as $furniture_id) {
            // Fetch the furniture name and price from the database based on the furniture ID
            $stmt = $connection->prepare("SELECT name, price FROM furniture WHERE furniture_id = ?");
            $stmt->bindParam(1, $furniture_id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $furniture_name = $result['name'];
            $furniture_price = $result['price'];

            // Add the furniture name to the array
            $selected_furniture_names[] = $furniture_name;

            // Calculate total furniture price
            $totalFurniturePrice += $furniture_price;
        }
    }

    $start_date = $_SESSION['booking_details']['start_date'];
    $end_date = $_SESSION['booking_details']['end_date'];

    // Create DateTime objects for the start and end date
    $startDateTime = new DateTime($start_date);
    $endDateTime = new DateTime($end_date);

    // Calculate the difference in days
    $diff = $startDateTime->diff($endDateTime);
    $numberOfDays = $diff->format('%a'); // %a will give the total number of days

    // Calculate the total room price based on the number of days
    $roomPricePerMonth = $roomPrice; // Room price fetched from the database
    $numberOfMonths = ceil($numberOfDays / 31); // Using ceil to round up to the nearest month

    $totalRoomPrice = $roomPricePerMonth * $numberOfMonths;

    $totalPrice = $totalRoomPrice + $totalFurniturePrice;
    $user_id = $_SESSION['user_id'];
    $block = $_SESSION['block'];
    $booking_details = $_SESSION['booking_details'];

    $room_id = $_SESSION['room_id'];

    $_SESSION['totalPrice'] = $totalPrice;

// Check if booking already exists
$check_stmt = $connection->prepare("SELECT * FROM bookings WHERE user_id = :user_id AND block = :block AND room_number = :room_number AND start_date = :start_date AND end_date = :end_date");
$check_stmt->bindParam(":user_id", $user_id);
$check_stmt->bindParam(":block", $block);
$check_stmt->bindParam(":room_number", $room_number);
$check_stmt->bindParam(":start_date", $booking_details['start_date']);
$check_stmt->bindParam(":end_date", $booking_details['end_date']);
$check_stmt->execute();
$existing_booking = $check_stmt->fetch();

// If booking doesn't exist, then proceed with the creation
if (!$existing_booking) {
    $stmt = $connection->prepare("INSERT INTO bookings (user_id, booking_type, block, room_number, room_id, start_date, end_date) VALUES (:user_id, :booking_type, :block, :room_number, :room_id, :start_date, :end_date)");
    $stmt->bindParam(":user_id", $user_id);
    $stmt->bindParam(":booking_type", $booking_details['room_type']); // Change booking_type to room_type from session
    $stmt->bindParam(":block", $block);
    $stmt->bindParam(":room_number", $room_number);
    $stmt->bindParam(":room_id", $room_id); // add this line
    $stmt->bindParam(":start_date", $booking_details['start_date']);    
    $stmt->bindParam(":end_date", $booking_details['end_date']);

    try {
        if (!$stmt->execute()) {
            die("Error recording booking.");
        } else {
            // Save the booking_id into the session
            $_SESSION['booking_id'] = $connection->lastInsertId();
        }
    } catch (PDOException $e) {
        die("Error recording booking: " . $e->getMessage());
    }
}

// Continue displaying the confirmation details...

    ?>
    
        <h2>Confirmation Details:</h2>
        <p><strong>Start Date:</strong> <?php echo $start_date; ?></p>
        <p><strong>End Date:</strong> <?php echo $end_date; ?></p>
        <p><strong>Room Type:</strong> <?php echo $roomType; ?></p>
        <p><strong>Block:</strong> <?php echo $_SESSION['block']; ?></p>
        <p><strong>Room Number:</strong> <?php echo $room_number; ?></p>
    
        
    <?php
   $p = "<strong>Selected Furniture:</strong>";
   if (!empty($selected_furniture_names)) {
       foreach ($selected_furniture_names as $item) {
           $p .= $item . ", ";
       }
   } else {
       $p .= "None";
   }
   echo $p . "</p>";
?>
</p>
        
    
        <p><strong>Total Price: </strong> RM <?php echo $totalPrice; ?></p>
    
        <div class="button-container">
            <button onclick="location.href='booking.php'">Go Back to Booking</button>
            <button onclick="location.href='payment.php'">Proceed to Payment</button>
        </div>
    </div>
    <div style="height: 100px;"></div>
  <a href="#" class="scrollup waves-effect waves-dark"><i class="fa fa-angle-up HillSide"></i></a>
<?php include('include/footer.php') ?>
<a href="#" class="scrollup waves-effect waves-dark"><i class="fa fa-angle-up HillSide"></i></a>
	<script src="js/jquery.js"></script>
	<script src="js/jquery.easing.1.3.js"></script>
	<script src="materialize/js/materialize.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.fanc ybox.pack.js"></script>
	<script src="js/jquery.fancybox-media.js"></script>  
	<script src="js/jquery.flexslider.js"></script>
	<script src="js/animate.js"></script>
	<!-- Vendor Scripts -->
	<script src="js/modernizr.custom.js"></script>
	<script src="js/jquery.zoomslider.min.js"></script>
	<script src="js/jquery.isotope.min.js"></script>
	<script src="js/jquery.magnific-popup.min.js"></script>
	<script src="js/animate.js"></script> 
	<script src="js/custom.js"></script>
</body> 

</html>    