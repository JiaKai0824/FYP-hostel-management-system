<?php
    // Include the dataconnection.php file to establish a database connection
    include 'dataconnection.php';
    session_start();

    // Fetch the furniture items from the database
    $stmt = $connection->prepare("SELECT * FROM furniture");
    $stmt->execute();
    $furniture_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Furniture Site</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="" />
	<meta name="author" content="http://code4berry.com" />
    <!-- normalize css -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="materialize/css/materialize.min.css" media="screen,projection" />
	<link href="css2/bootstrap.min.css" rel="stylesheet" />
	<link href="css2/fancybox/jquery.fancybox.css" rel="stylesheet"> 
	<link href="css2/flexslider.css" rel="stylesheet" /> 
	<link rel="stylesheet" type="text/css" href="css2/zoomslider.css" />
	<link href="css2/style.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css" integrity="sha512-NhSC1YmyruXifcj/KFRWoC561YpHpc5Jtzgvbuzx5VozKpWvQ+4nXhPdFgmx8xqexRcpAglTj9sIBWINXa8x5w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- font awesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- custom utilities css -->
    <link rel="stylesheet" href="css/utilities.css">
    <!-- custom main css -->
    <link rel="stylesheet" href="css/main.css">

    <style>
.checkbox-container {
    position: relative;
    display: inline-block;
    width: 32px;
    height: 32px;
    margin-left: 10px;
}

    .checkbox-container input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    .checkbox-custom {
    position: absolute;
    top: 0;
    left: 0;
    width: 32px;
    height: 32px;
    background-color: #fff;
    border: 2px solid #e91e63;
    border-radius: 2px;
    transition: all 0.3s;
}

    .checkbox-custom::after {
        content: "\f00c";
        font-family: "FontAwesome";
        font-size: 12px;
        color: #fff;
        position: absolute;
        top: 1px;
        left: 4px;
        opacity: 0;
        transition: all 0.3s;
    }

    .checkbox-container input:checked ~ .checkbox-custom {
        background-color: #e91e63;
    }

    .checkbox-container input:checked ~ .checkbox-custom::after {
        opacity: 1;
    }

    .new-product-item {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  text-align: center;
}

.centering-container {
    display: flex;
    justify-content: center;
}

.new-products-content {
  white-space: nowrap;
  overflow-x: auto;
}
</style>

</head>
<body>

    <?php include('include/header.php') ?>
   
   

    <!-- header -->
    <header class="header bg-light-brown flex" id="home">
        <div class="container">
            <div class="header-content grid text-center">
                <div class="header-left">
                    <h1>Select the Furniture</h1>
                    <p class="text">Improve ambiance with purpose-driven interiors designed to bring value to your environment</p>
                </div>

                <div class="header-right">
                    <img src="images/header-sofa-img.png">
                </div>
                <img src="images/header-shape.png" class="header-shape">
            </div>
        </div>
    </header>
    <!-- end of header -->



    <main>
   <!-- top new products section -->
   <section id="new-products" class="new-products py bg-light-grey-color-shade">
    <div class="container">
        <div class="section-title text-center">
            <h2>Additional Furniture</h2>
            <p class="lead">Choose the furniture you want to make your life more convenient.</p>
            <div class="line"></div>
        </div>
        
        <form action="confirmation.php" method="post">
            <div class="new-products-content grid">
                <!-- Loop through the fetched furniture items and display them -->
                <?php foreach ($furniture_items as $item): ?>
                    <div class="new-product-item">
    <label class="image">
        <!-- Replace the image src with the correct image URL -->
        <img src="images/<?php echo strtolower(str_replace(' ', '_', $item['name'])); ?>.jpg" alt="" style="width: 250px; height: 250px;">
        <span class="badge bg-brown text-white text-center text-uppercase">Rent</span>
        <input type="checkbox" class="furniture-checkbox" name="selected_furniture[]" value="<?php echo $item['furniture_id']; ?>">
        <span class="switch" onclick="toggleSelection(this)"></span>
    </label>
    <div class="info">
        <p class="name"><?php echo $item['name']; ?></p>
        <div class="price">
            <span class="new text-brown">RM <?php echo $item['price']; ?></span>
                <label class="checkbox-container">
                    <input type="checkbox" class="furniture-checkbox" name="selected_furniture[]" value="<?php echo $item['furniture_id']; ?>">
                    <span class="checkbox-custom"></span>
                </label>
            </div>
    </div>
</div>



<?php endforeach; ?>
            </div>
            <div class="submit-container text-center">
                <input type="submit" value="Next" class="btn-header text-white bg-brown">
            </div>
        </form>
    </div>
</section>
            <!-- end of top new products section -->
            <div class = "footer-end bg-dark">
                <div class = "container grid">
                    <p class = "text text-white text-center">&copy; FYP Hostel management system</p>
                    <div class = "flex payment">
                        <img src = "images/pay_1.png">
                        <img src = "images/pay_2.png">
                        <img src = "images/pay_3.png">
                        <img src = "images/pay_4.png">
                        <img src = "images/pay_5.png">
                    </div>
                </div>
            </div>
        </footer>
        <!-- end of footer -->
    </div>

    <!-- custom js -->
    <script src = "js/script.js"></script>

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

    <script>
function toggleSelection(element) {
    // Toggle the selection when the switch is clicked
    element.classList.toggle("selected");
}

function initializeScrollableContainer() {
    const container = document.querySelector(".new-products-content");
    container.style.display = "flex";
    container.style.overflowX = "auto";
    container.style.whiteSpace = "nowrap";
}

window.addEventListener("load", initializeScrollableContainer);
</script>
</body>
</html>