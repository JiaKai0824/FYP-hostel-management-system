<?php
session_start();
include 'dataconnection.php';

$error = array('student_id' => '', 'student_name' => '', 'student_email' => '', 'student_phone' => '', 'student_gender' => '', 'student_password' => '');

if(isset($_POST['submit'])) {
    $student_id= $_POST['student_id'];
    $student_name = $_POST['student_name'];
    $student_email = $_POST['student_email'];
    $student_phone = $_POST['student_phone'];
    $student_gender = strtolower($_POST['student_gender']);
    $student_password = $_POST['student_password'];
    $confirmpwd = $_POST['confirmpwd'];

    if ($student_password != $confirmpwd) {
        $error['student_password'] = "(!)Passwords do not match.";
    }

    // Add validation here
    if (!ctype_digit($student_id) || strlen($student_id) != 10) {
        $error['student_id'] = "(!)Student ID must be exactly 10 digits.";
    }

    if (!ctype_alpha(str_replace(' ', '', $student_name))) {
        $error['student_name'] = "(!)Name must contain only alphabets.";
    }

    if (!filter_var($student_email, FILTER_VALIDATE_EMAIL)) {
        $error['student_email'] = "(!)Invalid email format.";
    }

    if (!ctype_digit($student_phone) || !(strlen($student_phone) == 10 || strlen($student_phone) == 11)) {
        $error['student_phone'] = "(!)Mobile Number must be 10 or 11 digits.";
    }

    if ($student_gender != 'male' && $student_gender != 'female') {
        $error['student_gender'] = "(!)Gender can only be male or female.";
    }

    if (!(strlen($student_password) >= 8 && preg_match('/[A-Z]/', $student_password) && preg_match('/[a-z]/', $student_password) && preg_match('/[0-9]/', $student_password) && preg_match('/[\W]/', $student_password))) {
        $error['student_password'] = "(!)Password must be minimum 8 characters and contain at least 1 uppercase, 1 lowercase, 1 digit, and 1 symbol.";
    }

    // Check if student id already exists in the database
$stmt = $connection->prepare("SELECT student_id FROM student_information WHERE student_id = ?");
$stmt->execute([$student_id]);
$existing_id = $stmt->fetchColumn();

if ($existing_id) {
    $error['student_id'] = "This student ID is already registered.";
}
    // Check if there are no errors then insert into database
    if (!array_filter($error)) {
        // Hash the password
        $hashed_password = password_hash($student_password, PASSWORD_DEFAULT);

        // Prepare the INSERT statement
        $stmt = $connection->prepare("INSERT INTO student_information (student_id, student_name, student_email, student_phone, student_gender, student_password) 
                                      VALUES (:student_id, :student_name, :student_email, :student_phone, :student_gender, :hashed_password)");

        // Bind the parameters
        $stmt->bindParam(':student_id', $student_id);
        $stmt->bindParam(':student_name', $student_name);
        $stmt->bindParam(':student_email', $student_email);
        $stmt->bindParam(':student_phone', $student_phone);
        $stmt->bindParam(':student_gender', $student_gender);
        $stmt->bindParam(':hashed_password', $hashed_password);

        // Execute the statement
        if ($stmt->execute()) {
            $_SESSION['message'] = 'You have registered successfully. Please log in.';

            // Redirect to login page with success message
            header("Location: login.php");
            exit();
        } else {
            // Database insert failed, redirect to signup page with error message
            header("Location: signup.php?error=database_error");
            exit();
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>STUDENT SIGNUP PAGE</title>

    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="keywords" content="Art Sign Up Form Responsive Widget, Audio and Video players, Login Form Web Template, Flat Pricing Tables, Flat Drop-Downs, Sign-Up Web Templates,
		Flat Web Templates, Login Sign-up Responsive Web Template, Smartphone Compatible Web Template, Free Web Designs for Nokia, Samsung, LG, Sony Ericsson, Motorola Web Design"
    />

    <link href="web/css/style.css" rel="stylesheet" type="text/css" />

    <link href="web/css/fontawesome-all.css" rel="stylesheet" />

    <link href="//fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

<style>
    .error-message {
        color: red;
    }
</style>

</head>

<body>
    <header>
        <div class="container agile-banner_nav">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">

                <h1><a class="navbar-brand" href="home.php">MMU HOSTEL <span class="display"></span></a></h1>
            </div>
    </header>

    <h1>Student Sign Up</h1>
    <div class="w3l-login-form">
    <h2>Sign Up Here</h2>
    <form method="POST" action="signup.php">
        <div class="w3l-form-group">
            <label>Student ID</label>
            <div class="group">
                <i class="fas fa-id-badge"></i>
                <input type="text" class="form-control" name="student_id" placeholder="ID No" required="required" />
               
            </div>
        </div>
        <div class="w3l-form-group">
            <label>Full Name</label>
            <div class="group">
                <i class="fas fa-user"></i>
                <input type="text" class="form-control" name="student_name" placeholder="Full Name" required="required" />
                
            </div>
        </div>
        <div class="w3l-form-group">
            <label>Email</label>
            <div class="group">
                <i class="fas fa-user"></i>
                <input type="text" class="form-control" name="student_email" placeholder="Email" required="required" />
                
            </div>
        </div>
        <div class="w3l-form-group">
            <label>Mobile No</label>
            <div class="group">
                <i class="fas fa-phone"></i>
                <input type="text" class="form-control" name="student_phone" placeholder="Mobile No" required="required" />
                
            </div>
        </div>
        <div class="w3l-form-group">
            <label>Gender</label>
            <div class="group">
                <i class="fas fa-graduation-cap"></i>
                <input type="text" class="form-control" name="student_gender" placeholder="Male / Female" required="required" />
                
            </div>
        </div>
        <div class="w3l-form-group">
            <label>Password</label>
            <div class="group">
                <i class="fas fa-unlock"></i>
                <input type="password" class="form-control" name="student_password" placeholder="Password" required="required" />
                
            </div>
        </div>
        <div class="w3l-form-group">
            <label>Confirm Password</label>
            <div class="group">
                <i class="fas fa-unlock"></i>
                <input type="password" class="form-control" name="confirmpwd" placeholder="Confirm Password" required="required" />
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary btn-block" name="submit">Sign Up</button>
        <div id="error-message" class="error-message">
        <span class="error" id="studentIdError"><?php echo $error['student_id']; ?></span></br>
        <span class="error" id="studentNameError"><?php echo $error['student_name']; ?></span></br>
        <span class="error" id="studentEmailError"><?php echo $error['student_email']; ?></span></br>
        <span class="error" id="studentPhoneError"><?php echo $error['student_phone']; ?></span></br>
        <span class="error" id="studentGenderError"><?php echo $error['student_gender']; ?></span></br>
        <span class="error" id="studentPasswordError"><?php echo $error['student_password']; ?></span></br>
        </div>
    </form>
        <p class=" w3l-register-p">SignUp as a lecturer<a href="signup2.php" class="register"> Lecturer</a></p>
        <p class=" w3l-register-p">Go back Main<a href="home.php" class="register"> Home</a></p>
        <p class=" w3l-register-p">Already a member?<a href="login.php" class="register"> Login</a></p>
    </div>
    
</div>

<script>
        // Check if there are any error messages
        <?php if(isset($error['student_id']) && !empty($error['student_id'])) { ?>
            var studentIdError = "<?php echo $error['student_id']; ?>";
        <?php } ?> 
        <?php if(isset($error['student_name']) && !empty($error['student_name'])) { ?>
            var studentNameError = "<?php echo $error['student_name']; ?>";
        <?php } ?>
        <?php if(isset($error['student_email']) && !empty($error['student_email'])) { ?>
            var studentEmailError = "<?php echo $error['student_email']; ?>";
        <?php } ?>

        <?php if(isset($error['student_phone']) && !empty($error['student_phone'])) { ?>
            var studentPhoneError = "<?php echo $error['student_phone']; ?>";
        <?php } ?>
        <?php if(isset($error['student_gender']) && !empty($error['student_gender'])) { ?>
            var studentGenderError = "<?php echo $error['student_gender']; ?>";
        <?php } ?>
        <?php if(isset($error['student_password']) && !empty($error['student_password'])) { ?>
            var studentPasswordError = "<?php echo $error['student_password']; ?>";
        <?php } ?>

        // Other error messages...

        // Display error message if it exists
        if (typeof studentIdError !== 'undefined') {
            var errorMessage = document.getElementById('error-message');
            errorMessage.textHTML = studentIdError;
            errorMessage.style.display = 'block';
        }
        if (typeof studentNameError !== 'undefined') {
            var errorMessage = document.getElementByName('error-message');
            errorMessage.textHTML = studentNameError;
            errorMessage.style.display = 'block';
        }
        if (typeof studentEmailError !== 'undefined') {
            var errorMessage = document.getElementByEmail('error-message');
            errorMessage.textHTML = studentEmailError;
            errorMessage.style.display = 'block';
        }
        if (typeof studentPhoneError !== 'undefined') {
            var errorMessage = document.getElementByPhone('error-message');
            errorMessage.textHTML = studentPhoneError;
            errorMessage.style.display = 'block';
        }
        if (typeof studentGenderError !== 'undefined') {
            var errorMessage = document.getElementByGender('error-message');
            errorMessage.textHTML = studentGenderError;
            errorMessage.style.display = 'block';
        }
        if (typeof studentPasswordError !== 'undefined') {
            var errorMessage = document.getElementByPassword('error-message');
            errorMessage.textHTML = studentPasswordError;
            errorMessage.style.display = 'block';
        }
    </script>

</body>

</html>

