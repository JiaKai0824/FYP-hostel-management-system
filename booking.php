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

  <style>
  .home {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
  }

  .container h2 {
    font-size: 50px;
    text-align: center;
  }

  .content.grid {
    display: flex;
    justify-content: center;
  }

  .box {
    text-align: center;
    margin-bottom: 20px;
  }

  .box span {
    font-size: 24px;
  }

  .box input[type="date"] {
    border: none;
    background-color: #000; 
    color: #e91e63; 
    padding: 10px;
    border-radius: 5px;
    font-size: 24px;
    width: 250px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  }

  .box input[type="date"]::-webkit-calendar-picker-indicator {
    filter: invert(1); 
  }

  .box input[type="date"]::-webkit-inner-spin-button,
  .box input[type="date"]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }

  .room-image {
    width: 300px; 
    height: 200px; 
  }
</style>




<form method="post">
  <section class="home" id="home">
    <div class="container">
      <h2>Welcome to MMU HOSTEL</h2>
      <p style="font-size: 24px; text-align: center;">Select Date</p>
      
      <div class="content grid">
        <div class="box">
          <span>Check-in Date </span> <br>
          <input type="date" id="start-date" name="start_date" placeholder="29/20/2021" required>
        </div>
        <div class="box">
          <span>Check-out Date </span> <br>
          <input type="date" id="end-date" name="end_date" placeholder="29/20/2021" required>
        </div>
      </div>

      

    </div>
  </section>
</form>

  
  
  <section class="offer mtop" id="services">
    <div class="container">
      <div class="heading">
        <h5>ROOM OPTIONS </h5>
        <h3>Choose the room </h3>
      </div>

      <div class="content grid2 mtop">
        <div class="box flex">
        <div class="left">
        <img src="double.jpg" alt="" class="room-image" style="width: 300px; height: 350px;">

        </div>
          <div class="right">
            <h4>Double Room</h4></br>
            <p> Shared renting with friends will not be boring, it is very convenient to discuss homework with each other, and there is a lot of space.</p>
            <h5>From RM300/month</h5>
            <button id="double-room" class="flex1" onclick="checkAvailability('double')" style="color: #e91e63;">
              <span>Check Availability</span>
              <i class="fas fa-arrow-circle-right"></i>
            </button>
          </div>
        </div>
        <div class="box flex">
        <div class="left">
          <img src="single.jpg" alt="" class="room-image" style="width: 300px; height: 350px;">
        </div>
          <div class="right">
            <h4>Single Room</h4></br>
            <p>Not to be disturbed by anyone, quiet environment, like to live alone and want to have your own private space (recommended).</p>
            <h5>From RM500/month</h5>
            <button id="single-room" class="flex1" onclick="checkAvailability('single')" style="color: #e91e63;">
              <span>Check Availability</span>
              <i class="fas fa-arrow-circle-right"></i>
            </button>

          </div>
        </div>
      </div>
    </div>
  </section>
<script>
function checkAvailability(roomType) {
    // Get the selected dates from the input fields
    const start_date = new Date(document.querySelector('#start-date').value);
    const end_date = new Date(document.querySelector('#end-date').value);

    // Check if dates are valid
    if (isNaN(start_date.getTime()) || isNaN(end_date.getTime())) {
        alert('Please select both check-in and check-out dates.');
        return; // stop here if dates are invalid
    }
    
    // Check if end_date is later than start_date
    if (start_date >= end_date) {
        alert('Check-out date must be later than check-in date.');
        return; // stop here if dates are not valid
    }

    // Debugging: check if variables are assigned correctly
    console.log(start_date);
    console.log(end_date);
    console.log(roomType);

    // Send the selected dates and room type to the check availability page
    // Convert dates back to yyyy-mm-dd format
    const start_date_str = start_date.toISOString().split('T')[0];
    const end_date_str = end_date.toISOString().split('T')[0];

    window.location.href = `check_availability.php?start_date=${start_date_str}&end_date=${end_date_str}&room_type=${roomType}`;
    
    // Debugging: check if function is executed
    alert('Function executed');
}

</script>

<script>
window.onload = function() {
  var today = new Date();
  var dd = String(today.getDate()).padStart(2, '0');
  var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
  var yyyy = today.getFullYear();
  var maxYear = yyyy + 1;
  
  today = yyyy + '-' + mm + '-' + dd;
  var maxDate = maxYear + '-' + mm + '-' + dd;

  document.getElementById('start-date').setAttribute('min', today);
  document.getElementById('end-date').setAttribute('min', today);
  document.getElementById('end-date').setAttribute('max', maxDate);
}
</script>


          </div>
        </div>
      </div>
    </div>
  </section>

  <div style="height: 100px;"></div>

<?php include('include/footer.php') ?>

<a href="#" class="scrollup waves-effect waves-dark"><i class="fa fa-angle-up HillSide"></i></a>
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