<?php
include 'dataconnection.php';
session_start();

if (isset($_POST['booking_id']) && isset($_SESSION['user_id'])) {
    $booking_id = $_POST['booking_id'];
    $user_id = $_SESSION['user_id'];

    // First, get the room_id associated with the booking
    $stmt = $connection->prepare("SELECT room_id FROM bookings WHERE booking_id = :booking_id AND user_id = :user_id");
    $stmt->bindValue(':booking_id', $booking_id);
    $stmt->bindValue(':user_id', $user_id);
    $stmt->execute();
    $booking_info = $stmt->fetch(PDO::FETCH_ASSOC);
    $room_id = $booking_info['room_id'];

    // Now, decrease the current_capacity of the room by 1
    $stmt = $connection->prepare("UPDATE rooms SET current_capacity = current_capacity - 1 WHERE room_id = :room_id");
    $stmt->bindValue(':room_id', $room_id);
    $stmt->execute();

    // After this, update the status of the booking to "cancelled"
    $stmt = $connection->prepare("UPDATE bookings SET status = 'cancelled' WHERE booking_id = :booking_id AND user_id = :user_id");
    $stmt->bindValue(':booking_id', $booking_id);
    $stmt->bindValue(':user_id', $user_id);
    $stmt->execute();

    // Now you can redirect the user back to the history page with a success message
    header("Location: history.php?message=Booking successfully cancelled");
    exit();
} else {
    header("Location: history.php?message=Unable to cancel booking.");
    exit();
}
?>
