<?php
include 'dataconnection.php';
session_start();

$payment_message = '';

// Check if booking details are set
if(isset($_SESSION['booking_details']) && isset($_SESSION['booking_id'])){
    // Get booking details
    $booking_details = $_SESSION['booking_details'];
    $user_id = $_SESSION['user_id'];
    $room_id = $_SESSION['room_id'];
    $booking_id = $_SESSION['booking_id'];

    
    // update status to 'confirmed' after payment successful
    $stmt = $connection->prepare("
    UPDATE bookings 
    SET status = 'confirmed' 
    WHERE booking_id = ?
    ");
    $stmt->bindParam(1, $booking_id);
    $isSuccessful = $stmt->execute();
if (!$isSuccessful) {
    echo "Error: execute() failed. ";
    var_dump($stmt->errorInfo());
    exit();
}


  
    if ($stmt->errorCode() != '00000') {
      error_log("Error Code: " . $stmt->errorCode());
      error_log("Error Info: " . implode(", ", $stmt->errorInfo()));
  }

    if ($stmt->rowCount() > 0) {
        // Clear the booking details from the session after the process is done
        unset($_SESSION['booking_details']);
        unset($_SESSION['room_id']);
        unset($_SESSION['booking_id']);
  
        // redirect to payment success page
        //header('Location: paymentsuccess.php');
        
    } 
  }
  
?>

<!DOCTYPE html>
<html>
  <head>
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,400i,700,900&display=swap" rel="stylesheet">
  </head>
    <style>
      body {
        text-align: center;
        padding: 40px 0;
        background: #EBF0F5;
      }
        h1 {
          color: #88B04B;
          font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
          font-weight: 900;
          font-size: 40px;
          margin-bottom: 10px;
        }
        p {
          color: #404F5E;
          font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
          font-size:20px;
          margin: 0;
        }
      i {
        color: #9ABC66;
        font-size: 100px;
        line-height: 200px;
        margin-left:-15px;
      }
      .card {
        background: white;
        padding: 60px;
        border-radius: 4px;
        box-shadow: 0 2px 3px #C8D0D8;
        display: inline-block;
        margin: 0 auto;
      }
    </style>
    <body>
      <div class="card">
      <div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
        <i class="checkmark">✓</i>
      </div>
        <h1>Success</h1> 
        <p>We received your purchase request;<br/> we'll be in touch shortly!</p></br>
        <p><?php echo $payment_message; ?></p>
        <a href="home.php">Go Back Menu</a>
      </div>
    </body>
</html>