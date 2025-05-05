<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Hostel website - Home page</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="" />
	<meta name="author" content="http://code4berry.com" />
	<!-- css --> 
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="materialize/css/materialize.min.css" media="screen,projection" />
	<link href="css2/bootstrap.min.css" rel="stylesheet" />
	<link href="css2/fancybox/jquery.fancybox.css" rel="stylesheet"> 
	<link href="css2/flexslider.css" rel="stylesheet" /> 
	<link rel="stylesheet" type="text/css" href="css2/zoomslider.css" />
	<link href="css2/style.css" rel="stylesheet" />
</head>
<body>

	<style>
		.hostel-image {
    		height: 236px; /* Adjust the height as per your requirements */
    		object-fit: cover;
		}
	</style>

	<div id="wrapper" class="home-page"> 
		
		<!-- start header -->
		<?php include('include/header.php') ?>
		<!-- end header -->
		<section id="banner">
			<!-- Slider -->
			<div id="slider" data-zs-src='["img/photos/12.jpg", "img/photos/4.jpg", "img/photos/3.png"]' >
			</div>
			<!-- end slider --> 
		</section>  
		<section class="projects">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="aligncenter"><h2 class="aligncenter">Our Featured Hostels</h2>Students and teachers can carry out various activities within the school grounds, with easy access and no need to rush during class time. Not only that, the environment is very beautiful.</div>
						<br/>
					</div>
				</div>

				<div class="row service-v1 margin-bottom-40">
					<div class="col-md-4 md-margin-bottom-40">
						<div class="card small">
							<div class="card-image">
								<img class="img-responsive" src="img/bg_1.jpg" alt="">   
							</div>
							<div class="card-content"> 
								<p>
									<h4>Male Student Hostel</h4>
									<h5>Block A</h5>
									<a href="booking.php" class="btn btn-details">Book</a>
								</p>
							</div>
						</div>        
					</div>
					<div class="col-md-4 md-margin-bottom-40">
    					<div class="card small">
       			 			<div class="card-image">
            					<img class="img-responsive hostel-image" src="img/photos/bg_13.jpg" alt="">   
        					</div>
        					<div class="card-content">
            					<p>
                					<h4>Female Student Hostel</h4>
                					<h5>Block B</h5>
                					<a href="booking.php" class="btn btn-details">Book</a>
            					</p>
        					</div>
    					</div>        
					</div>

					<div class="col-md-4 md-margin-bottom-40">
						<div class="card small">
							<div class="card-image">
								<img class="img-responsive" src="img/bg_12.jpg" alt="">  
							</div>
							<div class="card-content">
								<p>
									<h4>Lecturer Hostel</h4>
									<h5>Block C</h5>
									<a href="booking.php" class="btn btn-details">Book</a>
								</p>
							</div>
						</div>        
					</div> 
				</div>
			</div>
		</section>

		<section class="section-padding gray-bg">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="section-title text-center">
							<h2>Our Students</h2>
							<p>Because the dormitory is very close to the school, students can save more time, and the sound insulation effect of the dormitory is excellent, so that the study and meditation will not be affected by external factors.</p>
						</div>
					</div>
				</div>
				<div class="row">

					<div class="col-md-6 col-sm-6">
						<div class="about-image">
							<img src="img/bg_6.jpg" alt="About Images">
						</div>
					</div>
					<div class="col-md-6 col-sm-6">
						<div class="about-text">
							<h3>About Us</h3>
							<p>MMU Hostel is a dormitory built near Multimedia University. It has a comfortable environment for students and teachers to have a good rest and relaxation. Because the rest is for walking a farther road, the location of this dormitory is excellent, quiet and more important. The dormitory provides complete facilities, and you only need to walk a few minutes to a convenience store if you want to buy something.</p>
							<p>MMUHostel has been well received by students and teachers since its establishment. No matter it is any time, you can enjoy some meals and coffee in the hall of the dormitory. Everyone can discuss homework in the hall, or chat and play games, because we value the dormitory very much. Whether the comfort level can satisfy everyone, and do our best under the condition of constantly obtaining opinions and improving.</p>
							<a href="aboutus.php" class="btn btn-primary waves-effect waves-dark">Learn More</a>
						</div>
					</div>
				</div>
			</div>
		</section>	  


		<?php include('include/footer.php') ?>
	</div>
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