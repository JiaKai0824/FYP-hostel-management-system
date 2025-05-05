<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>About Us</title>
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

  <style>  
  .card-container {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
  }

  .card {
    width: 30%;
    display: flex;
    flex-direction: column;
    align-items: center;
    background-color: #f2f2f2; /* 设置背景颜色为浅灰色 */
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* 添加阴影效果 */
  }

  .card .content {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 10px;
  }

  .card .img img {
    display: block;
    margin: 0 auto;
  }

  .card .cardContent span {
    color: #e91e63; /* 设置字体颜色为粉红色 */
    font-size: 16px; /* 设置字体大小为16像素 */
  }

  .space {
  margin-top: 100px;
  margin-bottom: 100px;
}
</style>


</head>

<body>

<?php include('include/header.php') ?>

<div class="space"></div>

<div class="container">
  <div class="card-container">
    <div class="card">
      <div class="content">
        <div class="img"><img src="Resume_Photo0.png" width="200" height="250"></div>
        <div class="cardContent">
          <h3>Ngo Wei Cheng<br><span>Web Developer</span></h3>
        </div>
      </div>
      <ul class="sci">
        <li style="--i:1">
          <a href="https://www.facebook.com/ngo.weicheng/"><i class="fa fa-facebook" aria-hidden="true"></i></a>
        </li>
        <li style="--i:2">
          <a href="https://www.instagram.com/weicheng_n/"><i class="fa fa-instagram" aria-hidden="true"></i></a>
        </li>
        <li style="--i:3">
          <a href="https://github.com/NgoWeiCheng"><i class="fa fa-github" aria-hidden="true"></i></a>
        </li>
      </ul>
    </div>
    <div class="card">
      <div class="content">
        <div class="img"><img src="Resume_Photo.jpeg" width="195" height="235"></div>
        <div class="cardContent">
          <h3>Lo Jia Kai<br><span>Web Developer</span></h3>
        </div>
      </div>
      <ul class="sci">
        <li style="--i:1">
          <a href="https://www.facebook.com/lo.j.kai.7"><i class="fa fa-facebook" aria-hidden="true"></i></a>
        </li>
        <li style="--i:2">
          <a href="https://www.instagram.com/just_kidding_0824/?fbclid=IwAR3_5S9kPDOyveUL0sj7qEqnbtwb1fEtLBdZJps3Jq-ygIhvcYsXLfhs8WU"><i class="fa fa-instagram" aria-hidden="true"></i></a>
        </li>
        <li style="--i:3">
          <a href="https://github.com/JiaKai0824"><i class="fa fa-github" aria-hidden="true"></i></a>
        </li>
      </ul>
    </div>
    <div class="card">
      <div class="content">
        <div class="img"><img src="Resume_Photo2.jpg" width="230" height="220"></div>
        <div class="cardContent">
          <h3>Lim Jin Sing<br><span>Grafic Designer</span></h3>
        </div>
      </div>
      <ul class="sci">
        <li style="--i:1">
          <a href="https://www.facebook.com/jinsing.lim"><i class="fa fa-facebook" aria-hidden="true"></i></a>
        </li>
        <li style="--i:2">
          <a href="https://www.instagram.com/jinsinglim/"><i class="fa fa-instagram" aria-hidden="true"></i></a>
        </li>
        <li style="--i:3">
          <a href="https://github.com/jinsing0311"><i class="fa fa-github" aria-hidden="true"></i></a>
        </li>
      </ul>
    </div>
  </div>
</div>

<div class="space"></div>

<?php include('include/footer.php') ?>

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
