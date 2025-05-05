<?php
include 'dataconnection.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
if (isset($_POST['start_date']) && isset($_POST['end_date'])) {
  $start_date = $_POST['start_date'];
  $end_date = $_POST['end_date'];
  
  // Redirect to check_availability.php passing the dates as query parameters
  header('Location: check_availability.php?start_date=' . $start_date . '&end_date=' . $end_date);
  exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $cardNumber = $_POST['cardNumber'];  // Assuming the card number is submitted via POST
  if (!isValidCardNumber($cardNumber)) {
      // Handle invalid card number
      die("Invalid card number");
  }
  // Process payment here

  // Assuming payment was successful, save booking
  $user_id = $_SESSION['user_id'];
  $room_id = $_SESSION['room_id'];
  $start_date = $_SESSION['start_date'];
  $end_date = $_SESSION['end_date'];
  $total_price = $_SESSION['totalPrice'];

  $stmt = $conn->prepare("INSERT INTO bookings (user_id, room_id, start_date, end_date, total_price) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("iissd", $user_id, $room_id, $start_date, $end_date, $total_price);
  $stmt->execute();
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <title>Hotel Booking Website</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="" />
	<meta name="author" content="http://code4berry.com" />
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
  <link rel="stylesheet" href="css/style3.css">

  <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />
  <link rel="stylesheet" href="materialize/css/materialize.min.css" media="screen,projection" />
	<link href="css2/bootstrap.min.css" rel="stylesheet" />
	<link href="css2/fancybox/jquery.fancybox.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css2/zoomslider.css" />
  <link href="css2/style.css" rel="stylesheet" />
</head>

<?php include('include/header.php') ?>
 

<form method="post">
    <section class="home" id="home">
      <div class="container">
        <h1></h1>
        <p>Welcome to MMU HOSTEL</p>

        <div class="content grid">
          <div class="box">
            <span>Rental Date </span> <br>
            <input type="date" id="start-date" name="start_date" placeholder="29/20/2021">
          </div>
          <div class="box">
            <span>Cancellation Date </span> <br>
            <input type="date" id="end-date" name="end_date" placeholder="29/20/2021">
          </div>
        </div>
      </div>
    </section>
  </form>

  <section class="room wrapper2 top" id="room">
    <div class="container">
      <div class="heading">
        <h5>OUR ROOMS</h5>
        <h2>Services included in MMUhostel</h2>
      </div>
      <div class="content flex mtop">
        <div class="left grid2">
          <div class="box">
            <i class="fas fa-desktop"></i>
            <p>Free Cost</p>
            <h3>Free use of public computers (unless vandalism)</h3>
          </div>
          <div class="box">
            <i class="fas fa-dollar-sign"></i>
            <p>Free Cost</p>
            <h3>Best rate guarantee</h3>
          </div>
          <div class="box">
            <i class="fab fa-resolving"></i>
            <p>Free Cost</p>
            <h3>Reservations 24/7</h3>
          </div>
          <div class="box">
            <i class="fal fa-alarm-clock"></i>
            <p>Free Cost</p>
            <h3>High-speed Wi-Fi</h3>
          </div>

        </div>
      </div>
    </div>
  </section>
  <section class="offer mtop" id="services">
    <div class="container">
      <div class="heading">
        <h5>ROOM OPTIONS </h5>
        <h3>Choose the room </h3>
      </div>

      <div class="content grid2 mtop">
        <div class="box flex">
          <div class="left">
            <img src="double.jpg" alt="">
          </div>
          <div class="right">
            <h4>Double Room</h4></br>
            <p> Shared renting with friends will not be boring, it is very convenient to discuss homework with each other, and there is a lot of space.</p>
            <h5>From RM300/month</h5>
            <button id="double-room" class="flex1" onclick="checkAvailability('double')">
    <span>Check Availability</span>
    <i class="fas fa-arrow-circle-right"></i>
</button>

          </div>
        </div>
        <div class="box flex">
          <div class="left">
            <img src="single.jpg" alt="">
          </div>
          <div class="right">
            <h4>Single Room</h4></br>
            <p>Not to be disturbed by anyone, quiet environment, like to live alone and want to have your own private space (recommended).</p>
            <h5>From RM500/month</h5>
            <button id="single-room" class="flex1" onclick="checkAvailability('single')">
    <span>Check Availability</span>
    <i class="fas fa-arrow-circle-right"></i>
</button>
<script>
function checkAvailability(roomType) {
    // Get the selected dates from the input fields
    const start_date = document.querySelector('#start-date').value;
    const end_date = document.querySelector('#end-date').value;
    
    // Debugging: check if variables are assigned correctly
    console.log(start_date);
    console.log(end_date);
    console.log(roomType);

    // Send the selected dates and room type to the check availability page
    window.location.href = `check_availability.php?start_date=${start_date}&end_date=${end_date}&room_type=${roomType}`;
    
    // Debugging: check if function is executed
    alert('Function executed');
}
</script>


          </div>
        </div>
      </div>
    </div>
  </section>

<?php include('include/footer.php') ?>
</body>
</html>