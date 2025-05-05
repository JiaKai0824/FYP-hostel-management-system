<?php	
	include('includes/config.php'); 
	$aid = $_SESSION['id'];
	$ret = "SELECT * FROM admin WHERE id=?";
	$stmt = $mysqli->prepare($ret);
	$stmt->bind_param('i', $aid);
	$stmt->execute();
	$res = $stmt->get_result();
    ?>
<!DOCTYPE html>
<html>
<head>
    <style>


    .navbar-default .navbar-toggle {
    border-color: #ddd;
    margin-top: 16px;
}

header .navbar {
    margin-bottom: 0;
}

.navbar-default {
    border: none;
    background: #222;
}


.navbar-brand {
    color: #e91e63;
    text-transform: uppercase;
    font-size: 24px;
    font-weight: 700;
    line-height: 1em;
    letter-spacing: -1px;
    margin-top: 21px;
    padding: 0 0 0 15px;
}
.navbar-default .navbar-brand{color: #e91e63;font-size: 24px;text-transform: uppercase;}
.navbar-default .navbar-brand:hover {
    color: #fff;
}
header .navbar-collapse  ul.navbar-nav {
    float: right;
    margin-right: 0;
}
header .navbar {min-height: 70px;padding: 18px 0;background: #222;}
.home-page header .navbar-default{
    background: #222;
    /* position: absolute; */
    width: 100%;
}

header .nav li a:hover,
header .nav li a:focus,
header .nav li.active a,
header .nav li.active a:hover,
header .nav li a.dropdown-toggle:hover,
header .nav li a.dropdown-toggle:focus,
header .nav li.active ul.dropdown-menu li a:hover,
header .nav li.active ul.dropdown-menu li.active a{
    -webkit-transition: all .3s ease;
    -moz-transition: all .3s ease;
    -ms-transition: all .3s ease;
    -o-transition: all .3s ease;
    transition: all .3s ease;
}


header .navbar-default .navbar-nav > .open > a,
header .navbar-default .navbar-nav > .open > a:hover,
header .navbar-default .navbar-nav > .open > a:focus {
    -webkit-transition: all .3s ease;
    -moz-transition: all .3s ease;
    -ms-transition: all .3s ease;
    -o-transition: all .3s ease;
    transition: all .3s ease;
}


header .navbar {
    min-height: 62px;
    padding: 0;
}

header .navbar-nav > li  {
    padding-bottom: 12px;
    padding-top: 12px;
    padding: 0 !important;
}

header  .navbar-nav > li > a {
    /* padding-bottom: 6px; */
    /* padding-top: 5px; */
    margin-left: 2px;
    line-height: 40px;
    font-weight: 700;
    -webkit-transition: all .3s ease;
    -moz-transition: all .3s ease;
    -ms-transition: all .3s ease;
    -o-transition: all .3s ease;
    transition: all .3s ease;
}

header .nav .caret {
    border-bottom-color: #e91e63;
    border-top-color: #e91e63;
}
.navbar-default .navbar-nav > .active > a,
.navbar-default .navbar-nav > .active > a:hover,
.navbar-default .navbar-nav > .active > a:focus {
  background-color: #fff;
}
.navbar-default .navbar-nav > .open > a,
.navbar-default .navbar-nav > .open > a:hover,
.navbar-default .navbar-nav > .open > a:focus {
  background-color: #e91e63;
  color: #fff;
}	

header .navigation {
	float:right;
}

header ul.nav li {
	border:none;
	margin:0;
}

header ul.nav li a {
	font-size: 13px;
	border:none;
	font-weight: 600;
	text-transform:uppercase;
}

header ul.nav li ul li a {	
	font-size:12px;
	border:none;
	font-weight:300;
	text-transform:uppercase;
}


.navbar .nav > li > a {
  color: #9a9a9a;
  text-shadow: none;
  border: 1px solid rgba(255, 255, 255, 0) !important;
}

.navbar .nav a:hover {
	background:none;
	color: #2e8eda;
}

.navbar .nav > .active > a,.navbar .nav > .active > a:hover {
	background:none;
	font-weight:700;
}

.navbar .nav > .active > a:active,.navbar .nav > .active > a:focus {
	background:none;
	outline:0;
	font-weight:700;
}

.navbar .nav li .dropdown-menu {
	z-index:2000;
}

header ul.nav li ul {
	margin-top:1px;
}
header ul.nav li ul li ul {
	margin:1px 0 0 1px;
}
.dropdown-menu .dropdown i {
	position:absolute;
	right:0;
	margin-top:3px;
	padding-left:20px;
}

.navbar .nav > li > .dropdown-menu:before {
  display: inline-block;
  border-right: none;
  border-bottom: none;
  border-left: none;
  border-bottom-color: none;
  content:none;
}
.navbar-default .navbar-nav>.active>a, .navbar-default .navbar-nav>.active>a:hover, .navbar-default .navbar-nav>.active>a:focus {color: #e91e63;background: #10cdff;border-radius: 0;}
.navbar-default .navbar-nav>li>a:hover, .navbar-default .navbar-nav>li>a:focus {
  color: #e91e63;
  background-color: transparent;
}

ul.nav li.dropdown a {
	z-index:1000;
	display:block;
}

.navbar-nav li a {
    color: grey;
}
		
.navbar-nav li a:hover {
    color: white;
    background-color: #222;
}

.navbar-brand:hover {
    color: #fff;
}
    </style>
</head>
<body>

<?php	
	$aid=$_SESSION['id'];
	$ret="select * from admin where id=?";
	$stmt= $mysqli->prepare($ret) ;
	$stmt->bind_param('i',$aid);
	$stmt->execute() ;
	$res=$stmt->get_result();
	while($row=$res->fetch_object())
	{
	?>	
    <header style="position: fixed; top: 0; left: 0; right: 0; z-index: 9999; background-color: #222;">
        <div class="navbar-header">
            <a href="dashboard.php" class="navbar-brand">MMU Hostel</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a class="waves-effect waves-dark" href="admin-profile.php"><?php echo $row->username;?> Profile</a></li>
                <li><a class="waves-effect waves-dark" href="logout.php">Logout</a></li>
            </ul>
        </div>
		
    </header>
	<?php } ?>
</body>
</html>

