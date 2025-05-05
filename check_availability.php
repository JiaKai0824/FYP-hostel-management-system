<?php
include 'dataconnection.php';
// At the top of check_availability.php
session_start();

// Get the user type
$user_type = $_SESSION['user_type'];
$block = 'C';

if ($user_type == 'student_information') {
    $block = $_SESSION['student_gender'];   
    if($_SESSION['student_gender'] == 'male') 
    {
        $block = 'A';
    }else if($_SESSION['student_gender'] == 'female')
    {
        $block = "B";
    }
         
} else if ($user_type == 'lecturer') {
    $block = 'C';
}

$_SESSION['block'] = $block;

// Get user input from booking.php
if(isset($_GET['start_date']) && isset($_GET['end_date']) && isset($_GET['room_type'])){
    $start_date = $_GET['start_date'];
    $end_date = $_GET['end_date'];
    $room_type = $_GET['room_type'];

    $_SESSION['booking_details'] = [
        'start_date' => $start_date,
        'end_date' => $end_date,
        'room_type' => $room_type,
    ];

    // Check if rooms are available
    if($room_type == "single"){
        $stmt = $connection->prepare("SELECT room_id FROM rooms WHERE room_type = 'single' AND block = ? AND is_available = 1 AND NOT EXISTS (SELECT 1 FROM bookings WHERE room_id = rooms.room_id AND ((start_date BETWEEN ? AND ?) OR (end_date BETWEEN ? AND ?) OR (? BETWEEN start_date AND end_date) OR (? BETWEEN start_date AND end_date))) LIMIT 1");

        try {
            $stmt->execute([$block, $start_date, $end_date, $start_date, $end_date, $start_date, $end_date]);

            $available_room_id = $stmt->fetchColumn();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        if($available_room_id){
            // Single room available, store room_id in session and redirect to furniture.php
            $_SESSION['room_id'] = $available_room_id;
            header('Location: furniture.php?start_date=' . $start_date . '&end_date=' . $end_date . '&room_type=' . $room_type);
            exit();
        } else {
            // Single room not available, show message
            echo "<script>alert('No single room available'); window.location.href = 'booking.php';</script>";
        }
    } else if($room_type == "double"){
        $stmt = $connection->prepare("SELECT room_id FROM rooms WHERE room_type = 'double' AND block = ? AND is_available = 1 AND NOT EXISTS (SELECT 1 FROM bookings WHERE room_id = rooms.room_id AND ((start_date BETWEEN ? AND ?) OR (end_date BETWEEN ? AND ?) OR (? BETWEEN start_date AND end_date) OR (? BETWEEN start_date AND end_date))) LIMIT 1");

        try {
            $stmt->execute([$block, $start_date, $end_date, $start_date, $end_date, $start_date, $end_date]);

            $available_room_id = $stmt->fetchColumn();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        if($available_room_id){
            // Double room available, store room_id in session and redirect to furniture.php
            $_SESSION['room_id'] = $available_room_id;
            header('Location: furniture.php?start_date=' . $start_date . '&end_date=' . $end_date . '&room_type=' . $room_type);
            exit();
        } else {
            // Double room not available, show message
            echo "<script>alert('No double room available'); window.location.href = 'booking.php';</script>";
        }
    }
} else {
    // Redirect to booking.php if query parameters are not set
    header('Location: booking.php');
    exit();
}
?>
