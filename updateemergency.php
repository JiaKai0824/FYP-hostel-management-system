<?php
include 'dataconnection.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id']; 
$user_type = $_SESSION['user_type'];

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
    }
    
    // A simple regex to validate phone numbers, replace it with your own validation
    if (!preg_match("/^[0-9]{10}$/", $phone)) {
        $errors['phone'] = "Invalid phone number";
    }
    

    // Your validation here

    // Assuming validation passed, update the database
    if (empty($errors)) {
        if ($user_type == 'student') {
            $emergency_name = $_POST['Emergency_contact_name'];
            $emergency_phone = $_POST['Emergency_contact_phone'];
            
            $sql = "UPDATE student_information SET student_email = ?, student_phone = ?, Emergency_contact_name = ?, Emergency_contact_phone = ? WHERE student_id = ?";
            $stmt = $connection->prepare($sql);
            if (!$stmt->execute([$email, $phone, $emergency_name, $emergency_phone, $user_id])) {
                print_r($stmt->errorInfo());
            }
        } elseif ($user_type == 'lecturer') {
            $sql = "UPDATE lecturer SET lec_email = ?, lec_phone = ? WHERE lec_id = ?";
            $stmt = $connection->prepare($sql);
            if (!$stmt->execute([$email, $phone, $user_id])) {
                print_r($stmt->errorInfo());
            }
        }
        // Redirect to the userprofile.php to see the changes
        header("Location: userprofile.php");
        exit();
        
            }
        }



        