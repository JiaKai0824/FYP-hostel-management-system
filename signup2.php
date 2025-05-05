<?php
include 'dataconnection.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$error = array('lec_id' => '', 'lec_name' => '', 'lec_email' => '', 'lec_phone' => '', 'lec_password' => '', 'confirmpwd' => '');


if(isset($_POST['submit'])) {
    $lec_id= $_POST['lec_id'];
    $lec_name = $_POST['lec_name'];
    $lec_email = $_POST['lec_email'];
    $lec_phone = $_POST['lec_phone'];
    $lec_password = $_POST['lec_password'];
    $confirmpwd = $_POST['confirmpwd'];

    // Validate lecturer ID
    if (strlen($lec_id) != 7 || !preg_match("/^mu\d{5}$/", $lec_id)) {
        $error['lec_id'] = "(!)Lecturer ID must start with 'mu' followed by 5 numbers.";
    }
    

    // Validate lecturer name
    if (!ctype_alpha(str_replace(' ', '', $lec_name))) {
        $error['lec_name'] = "(!)Name must only contain alphabets and spaces.";
    }

    // Validate email
    if (!filter_var($lec_email, FILTER_VALIDATE_EMAIL)) {
        $error['lec_email'] = "(!)Invalid email format.";
    }

    // Validate phone number
    if (!ctype_digit($lec_phone) || !(strlen($lec_phone) == 10 || strlen($lec_phone) == 11)) {
        $error['lec_phone'] = "(!)Phone number must be 10 or 11 digits.";
    }

    // Validate password
    if (!preg_match('/^(?=.*\d)(?=.*[A-Za-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{8,}$/', $lec_password)) {
        $error['lec_password'] = "(!)Password must be minimum 8 characters, at least one uppercase letter, one lowercase letter, one number and one special character.";
    }

    // Check password confirmation
    if ($lec_password != $confirmpwd) {
        $error['confirmpwd'] = "(!)Passwords do not match.";
    }

// Remove the block where you checked for non-empty $error and returned.

// ...

// Before hashing the password and inserting into the database, check if there are any errors:

    // Before inserting into the database:
    $stmt = $connection->prepare("SELECT lec_id FROM lecturer WHERE lec_id = ?");
    $stmt->execute([$lec_id]);
    $existing_id = $stmt->fetchColumn();
    
    if ($existing_id) {
        $error['lec_id'] = "This ID is already registered.";
    }

    $hasErrors = false;

    foreach ($error as $field_error) {
        if (!empty($field_error)) {
            $hasErrors = true;
            break;
        }
    }
    
    if($hasErrors) {
        // There are validation errors, skip database insert
    } else {
        // Hash the password
        $hashed_password = password_hash($lec_password, PASSWORD_DEFAULT);
    
        // Prepare the INSERT statement
        $stmt = $connection->prepare("INSERT INTO lecturer (lec_id, lec_name, lec_email, lec_phone, lec_password) 
                                  VALUES (?, ?, ?, ?, ?)");
    
if ($stmt === false) {
    echo "Failed to prepare SQL statement.";
}
// Execute the statement
else if ($stmt->execute([$lec_id, $lec_name, $lec_email, $lec_phone, $hashed_password])) {
    // Successful registration
    $_SESSION['message'] = 'You have registered successfully. Please log in.';
    header("Location: login.php");
    exit();
} else {
    // Database insert failed, redirect to signup page with error message
    header("Location: signup2.php?error=database_error");
    exit();
}

    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Lecturer SIGNUP PAGE</title>

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

    <h1>Lecturer Sign Up</h1>
    <div class="w3l-login-form">
    <h2>Sign Up Here</h2>
    <form method="POST" action="signup2.php">
        <div class="w3l-form-group">
            <label>Lecturer ID</label>
            <div class="group">
                <i class="fas fa-id-badge"></i>
                <input type="text" class="form-control" name="lec_id" placeholder="ID No" required="required" />
                
            </div>
        </div>
        <div class="w3l-form-group">
            <label>Full Name</label>
            <div class="group">
                <i class="fas fa-user"></i>
                <input type="text" class="form-control" name="lec_name" placeholder="Full Name" required="required" />
                
            </div>
        </div>
        <div class="w3l-form-group">
            <label>Email</label>
            <div class="group">
                <i class="fas fa-user"></i>
                <input type="text" class="form-control" name="lec_email" placeholder="Email" required="required" />
                
            </div>
        </div>
        <div class="w3l-form-group">
            <label>Mobile No</label>
            <div class="group">
                <i class="fas fa-phone"></i>
                <input type="text" class="form-control" name="lec_phone" placeholder="Mobile No" required="required" />
                
            </div>
        </div>
        <div class="w3l-form-group">
            <label>Password</label>
            <div class="group">
                <i class="fas fa-unlock"></i>
                <input type="password" class="form-control" name="lec_password" placeholder="Password" required="required" />
                
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
        <span class="error" id="lecturerIdError"><?php echo $error['lec_id']; ?></span></br>
        <span class="error" id="lecturerNameError"><?php echo $error['lec_name']; ?></span></br>
        <span class="error" id="lecturerEmailError"><?php echo $error['lec_email']; ?></span></br>
        <span class="error" id="lecturerPhoneError"><?php echo $error['lec_phone']; ?></span></br>
        <span class="error" id="lecturerPasswordError"><?php echo $error['lec_password']; ?></span></br>
        </div>
    </form>
        <p class=" w3l-register-p">SignUp as a Student<a href="signup.php" class="register"> Student</a></p>
        <p class=" w3l-register-p">Go back Main<a href="home.php" class="register"> Home</a></p>
        <p class=" w3l-register-p">Already a member?<a href="login.php" class="register"> Login</a></p>
    </div>
    
</div>

<script>
        // Check if there are any error messages
        <?php if(isset($error['lec_id']) && !empty($error['lec_id'])) { ?>
            var lecturerIdError = "<?php echo $error['lec_id']; ?>";
        <?php } ?> 
        <?php if(isset($error['lec_name']) && !empty($error['lec_name'])) { ?>
            var lecturerNameError = "<?php echo $error['lec_name']; ?>";
        <?php } ?>
        <?php if(isset($error['lec_email']) && !empty($error['lec_email'])) { ?>
            var lecturerEmailError = "<?php echo $error['lec_email']; ?>";
        <?php } ?>
        <?php if(isset($error['lec_phone']) && !empty($error['lec_phone'])) { ?>
            var lecturerPhoneError = "<?php echo $error['lec_phone']; ?>";
        <?php } ?>
        <?php if(isset($error['lec_password']) && !empty($error['lec_password'])) { ?>
            var lecturerPasswordError = "<?php echo $error['lec_password']; ?>";
        <?php } ?>

        // Other error messages...

        // Display error message if it exists
        if (typeof lecturerIdError !== 'undefined') {
            var errorMessage = document.getElementById('error-message');
            errorMessage.textHTML = lecturerIdError;
            errorMessage.style.display = 'block';
        }
        if (typeof lecturerNameError !== 'undefined') {
            var errorMessage = document.getElementByName('error-message');
            errorMessage.textHTML = lecturerNameError;
            errorMessage.style.display = 'block';
        }
        if (typeof lecturerEmailError !== 'undefined') {
            var errorMessage = document.getElementByEmail('error-message');
            errorMessage.textHTML = lecturerEmailError;
            errorMessage.style.display = 'block';
        }
        if (typeof lecturerPhoneError !== 'undefined') {
            var errorMessage = document.getElementByPhone('error-message');
            errorMessage.textHTML = lecturerPhoneError;
            errorMessage.style.display = 'block';
        }
        if (typeof lecturerPasswordError !== 'undefined') {
            var errorMessage = document.getElementByPassword('error-message');
            errorMessage.textHTML = lecturerPasswordError;
            errorMessage.style.display = 'block';
        }
    </script>

</body>

</html> 

