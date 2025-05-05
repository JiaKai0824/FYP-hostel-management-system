<?php
include 'dataconnection.php';

session_start();

if (isset($_SESSION['booking_id'])) {
    // Get booking ID from the session
    $booking_id = $_SESSION['booking_id'];

    if (isset($_SESSION['booking_details']['selected_furniture'])) {
        // Get selected furniture IDs from the session
        $selected_furniture = $_SESSION['booking_details']['selected_furniture'];

        // Loop through the selected furniture items and insert them into the furniture_booking table
        foreach ($selected_furniture as $furniture_id) {
            $stmt = $connection->prepare("INSERT INTO furniture_booking (booking_id, furniture_id, quantity) VALUES (?, ?, ?)");
if (!$stmt->execute([$booking_id, $furniture_id, 1])) {
    var_dump($stmt->errorInfo());
}
        }

        // Clear the selected furniture from the session
        unset($_SESSION['booking_details']['selected_furniture']);
    }

    // Redirect the user to the success page
    header('Location: paymentsuccess.php');
    exit();
} 

?>
