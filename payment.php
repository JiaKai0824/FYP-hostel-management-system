<?php

include 'dataconnection.php';

session_start();

$totalPrice = $_SESSION['totalPrice'] ?? 0;

if(isset($_SESSION['booking_id'])){ // check if the session variable is set
    $booking_id = $_SESSION['booking_id']; // if it is set, assign it to a variable
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve all form data
    $cardNumber = $_POST['cardNumber'];
    $expiryMonth = $_POST['expiryMonth'];
    $expiryYear = $_POST['expiryYear'];
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $dob_day = $_POST['dob_day'];
$dob_month = $_POST['dob_month'];
$dob_year = $_POST['dob_year'];
    $gender = $_POST['gender'];
    $cardCVC = $_POST['cardCVC'];
    $amount = $_SESSION['totalPrice'] ?? 0;
    $paymentMethod = $_POST['payment_method'];
    $dob = $dob_year . '-' . $dob_month . '-' . $dob_day;

    
    

    // Check if user already exists
    $stmt = $connection->prepare("SELECT * FROM user_details WHERE user_id = ?");
    $stmt->bindParam(1, $_SESSION['user_id']);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // User already exists, update the user details
        $stmt = $connection->prepare("UPDATE user_details SET full_name = ?, email = ?, dob = ?, gender = ? WHERE user_id = ?");
    $stmt->bindParam(1, $fullName);
    $stmt->bindParam(2, $email);
    $stmt->bindParam(3, $dob);
    $stmt->bindParam(4, $gender);
    $stmt->bindParam(5, $_SESSION['user_id']);
    $stmt->execute();
    } else {
        // User doesn't exist, perform the insertion
        $stmt = $connection->prepare("INSERT INTO user_details (user_id, full_name, email, dob, gender) VALUES (?, ?, ?, ?, ?)");
        $stmt->bindParam(1, $_SESSION['user_id']);
        $stmt->bindParam(2, $fullName); 
        $stmt->bindParam(3, $email);
        $stmt->bindParam(4, $dob);
        $stmt->bindParam(5, $gender);
        $stmt->execute();
    }

    // Save payment details
    $expiryDate = $expiryYear . '-' . $expiryMonth . '-01';  // Assuming day is not important
    $paymentDate = date("Y-m-d H:i:s"); // Current date and time
    $stmt = $connection->prepare("INSERT INTO payments (user_id, booking_id, card_number, expiry_date, cardCVC, amount, payment_method, payment_date) VALUES (:user_id, :booking_id, :card_number, :expiry_date, :cardCVC, :amount, :payment_method, :payment_date)");

    
$stmt->bindParam(":user_id", $_SESSION['user_id']);
$stmt->bindParam(":card_number", $cardNumber);
$stmt->bindParam(':booking_id', $_SESSION['booking_id']);
$stmt->bindParam(":expiry_date", $expiryDate);
$stmt->bindParam(":cardCVC", $cardCVC);
$stmt->bindParam(":amount", $amount);
$stmt->bindParam(":payment_method", $paymentMethod);
$stmt->bindParam(":payment_date", $paymentDate);
    if (!$stmt->execute()) {
        $error = "Error saving payment details.";
    }

    // Assuming payment was successful, update room availability
    $room_id = $_SESSION['room_id'];    
    $booking_details = $_SESSION['booking_details'];
    $user_id = $_SESSION['user_id'];
    
    
    $furniture_details = null;
    $furniture_type = null;
    if (isset($_SESSION['furniture_details'])) {
        $furniture_details = $_SESSION['furniture_details'];
        $furniture_type = $furniture_details['furniture_type'];
    }

    // Get the block and room number from the room_id
    $stmt = $connection->prepare("SELECT block, room_number FROM rooms WHERE room_id = ?");
    $stmt->bindParam(1, $room_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $block = $result['block'];
    $room_number = $result['room_number'];
    
    // Update current_capacity
$stmt = $connection->prepare("
UPDATE rooms 
SET current_capacity = current_capacity + 1
WHERE room_id = ?
");
$stmt->bindParam(1, $room_id);
$stmt->execute();

// Update is_available
$stmt = $connection->prepare("
UPDATE rooms 
SET is_available = CASE 
    WHEN current_capacity < max_capacity THEN 1
    ELSE 0
END
WHERE room_id = ?
");
$stmt->bindParam(1, $room_id);
$stmt->execute();


    if ($stmt->execute()) {
        // Redirect to a success page
       
        header("Location: furniture_process.php");
        exit();
    } else {
        // Handle error, if needed
    }
}


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Form</title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="" />
	<meta name="author" content="http://code4berry.com" />

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	
	<link href="css2/bootstrap.min.css" rel="stylesheet" />
	<link href="css2/fancybox/jquery.fancybox.css" rel="stylesheet"> 
	<link href="css2/flexslider.css" rel="stylesheet" /> 
	<link rel="stylesheet" type="text/css" href="css2/zoomslider.css" />
	<link href="css2/style.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-ezoxp5+9b6h57yam8cpvoa5/3wI5X+Kd/4AyX3bISmAcvooGSE56FYPKBbPJEW1C" crossorigin="anonymous">

    <link href="paymentform.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
        integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="css2/style2.css">

    <style>
        .error {
        color: red;
        margin: 10px 0;
        font-weight: bold;
    }

    .privacy-policy {
        display: flex;
        align-items: center;
        margin-top: 10px;
    }

    .checkbox-container {
        display: inline-block;
        position: relative;
        padding-left: 25px;
        cursor: pointer;
        user-select: none;
    }

    .checkbox-container input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 18px;
        width: 18px;
        background-color: #eee;
    }

    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    .checkbox-container input:checked ~ .checkmark:after {
        display: block;
    }

    .checkbox-container .checkmark:after {
        left: 6px;
        top: 2px;
        width: 5px;
        height: 10px;
        border: solid #2196F3;
        border-width: 0 3px 3px 0;
        transform: rotate(45deg);
    }

    .privacy-text {
        margin-left: 5px;
        color: blue;
        text-decoration: none;
        cursor: pointer;
    }

    .expiry-icon {
    display: inline-block;
    margin-right: 5px;
}
</style>
</head>

<body>

    <?php include('include/header.php') ?>

    <div class="wrapper">
        <h2>Payment Form</h2>
        <form method="POST" action="payment.php" id="my-form" onsubmit="return validateForm();">
            <h4>Account</h4>
            <div class="input-group">
                <div class="input-box">
                    <input type="text" placeholder="Full Name" name="fullName" required class="name">
                    <i class="fa fa-user icon"></i>
                </div>
                <div class="input-box">
                    <input type="text" placeholder="Total Price" value="RM <?php echo $totalPrice; ?>" readonly class="name">
                    <i class="fa fa-money icon"></i>
                </div>
            </div>
            <div class="input-group">
                <div class="input-box">
                    <input type="email" placeholder="Email Adress" name ="email" required class="name">
                    <i class="fa fa-envelope icon"></i>
                </div>
            </div>
            <div class="input-group">
                <div class="input-box">
                    <h4> Date of Birth</h4>
                    <input type="text" placeholder="DD" name="dob_day" class="dob">
                    <input type="text" placeholder="MM" name="dob_month" class="dob">
                    <input type="text" placeholder="YYYY" name="dob_year" class="dob">
                </div>
                <div class="input-box">
                    <h4> Gender</h4>
                    <input type="radio" id="b1" name="gender" value="Male" checked class="radio">
                    <label for="b1">Male</label>
                    <input type="radio" id="b2" name="gender" value="Female" class="radio">
                    <label for="b2">Female</label>
                </div>
            </div>
            <div class="input-group">
                <div class="input-box">
                    <h4>Payment Details</h4>
                    <input type="radio" name="payment_method" id="bc1" value="Credit Card" checked class="radio">
                    <label for="bc1"><span><i class="fa fa-credit-card"></i> Credit Card</span></label>
                    <input type="radio" name="payment_method" id="bc2" value="Credit Card" class="radio">
                    <label for="bc2"><span><i class="fa fa-credit-card"></i> Debit Card</span></label>
                </div>
            </div>
            <!-- Card Number -->
<div class="input-group">
    <div class="input-box">
        <input type="text" name="cardNumber" placeholder="Card Number" pattern="\d{16}" required autocomplete="off" required class="name">
        <i class="fa fa-credit-card icon"></i>
    </div>
</div>

<!-- Card CVC -->
<div class="input-group">
    <div class="input-box">
        <input type="text" name="cardCVC" placeholder="Card CVC" pattern="\d{3}" required class="name">
        <i class="fa fa-lock icon"></i>
    </div>
</div>

    <!-- Expiry Date -->
    <div class="input-group">
        <div class="input-box">
        <span class="expiry-icon">&#128337;</span>
            <input type="text" name="expiryMonth" placeholder="Expiry Month (MM)" pattern="(0[1-9]|1[0-2])" required class="name">
            <input type="text" name="expiryYear" placeholder="Expiry Year (YYYY)" pattern="\d{4}" required class="name">
        </div>
    </div>

    <div class="input-group">   
        <div class="input-box"> 
        <button id="submit-button" type="submit">PAY NOW</button>
        </div>
    </div>
    
    <div class="privacy-policy">
        <label class="checkbox-container">
            <input type="checkbox" id="privacy-checkbox" name="privacyPolicyAccepted" require>
            <span class="checkmark"></span>
        </label>
        <a href="policy.php" class="privacy-text">Privacy Policy</a>
    </div>
    
</form>


    </div>



    <div style="height: 100px;"></div>
  <a href="#" class="scrollup waves-effect waves-dark"><i class="fa fa-angle-up HillSide"></i></a>

<a href="#" class="scrollup waves-effect waves-dark"><i class="fa fa-angle-up HillSide"></i></a>
<script type="text/javascript">
function submitForm() {
    // Disable the submit button
    document.getElementById('submit-button').disabled = true;
    
    // Submit the form
    document.getElementById('my-form').submit();
}
</script>

    </div>


    <?php include('include/footer.php') ?>
    <div style="height: 100px;"></div>
  <a href="#" class="scrollup waves-effect waves-dark"><i class="fa fa-angle-up HillSide"></i></a>

<a href="#" class="scrollup waves-effect waves-dark"><i class="fa fa-angle-up HillSide"></i></a>
<script type="text/javascript">
function submitForm() {
    // Disable the submit button
    document.getElementById('submit-button').disabled = true;
    
    // Submit the form
    document.getElementById('my-form').submit();
}
</script>

<script>
function validateForm() {
    return validateCardNumber() && validateExpiryDate() && validatePrivacyPolicy();
}

function validateCardNumber() {
    var cardNumber = document.querySelector('input[name="cardNumber"]').value;
    if (!luhnCheck(cardNumber)) {
        alert("Invalid card number");
        return false;
    }
    return true;
}

function luhnCheck(value) {
    // remove non-digit characters
    value = value.replace(/\D/g, '');

    // implement Luhn algorithm
    let sum = 0;
    let shouldDouble = false;
    for (let i = value.length - 1; i >= 0; i--) {
        let digit = parseInt(value.charAt(i));

        if (shouldDouble) {
            if ((digit *= 2) > 9) digit -= 9;
        }

        sum += digit;
        shouldDouble = !shouldDouble;
    }
    return (sum % 10) == 0;
}
function validatePrivacyPolicy() {
    // Get the checkbox element
    const checkbox = document.getElementById('privacy-checkbox');

    // Check if the checkbox is not checked
    if (!checkbox.checked) {
        alert('Please read and accept the Privacy Policy.');
        return false;
    }

    // If validation passed, return true
    return true;
}

</script>

	<script src="js/jquery.js"></script>
	<script src="js/jquery.easing.1.3.js"></script>
	<script src="materialize/js/materialize.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.fancybox.pack.js"></script>
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
