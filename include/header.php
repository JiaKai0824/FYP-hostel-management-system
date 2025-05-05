<?php
// Start the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

?>

<header>
	<div class="navbar navbar-default navbar-static-top">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand" href="home.php"><i class="icon-info-blocks material-icons"></i> MMU Hostel</a>
			</div>
			<div class="navbar-collapse collapse ">
				<ul class="nav navbar-nav">
					<li class="HillSide"><a class="waves-effect waves-dark" href="home.php">Home</a></li> 
					<li><a class="waves-effect waves-dark" href="portfolio.php">Gallery</a></li>
					<li><a class="waves-effect waves-dark" href="aboutus.php">Contact</a></li>
					<li><a class="waves-effect waves-dark" href="booking.php">Booking</a></li>
					<?php 
                    if(isset($_SESSION['user_id'])) {
                    echo '<li class="dropdown">
                    <a href="#" class="dropdown-toggle waves-effect waves-dark" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'.$_SESSION['user_id'].'<span class="caret"></span></a>
                   <ul class="dropdown-menu">
                  <li><a href="userprofile.php">User Profile</a></li>
                  <li role="separator" class="divider"></li>
                  <li><a href="logout.php">Logout</a></li>
                   </ul>
                     </li>';
                    } else {
                     echo '<li><a class="waves-effect waves-dark" href="login.php">Login</a></li>';
                   }
                     ?>
				</ul>
			</div>
		</div>
	</div>
</header>
