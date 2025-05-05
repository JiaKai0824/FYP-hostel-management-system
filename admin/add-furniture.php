<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];

    // Sanitize the name and generate the image name
    $sanitized_name = strtolower(str_replace(' ', '_', $name));
    $imageName = $sanitized_name . '.jpg';

    // Set the target file path
    $target_file = "C:/xampp/htdocs/dashboard/FYP hostel management system/images/" . $imageName;

    if (isset($_FILES['imageToUpload'])) {
        $imageTmpName = $_FILES['imageToUpload']['tmp_name'];
        move_uploaded_file($imageTmpName, $target_file);
        echo "Image uploaded successfully.";
    } else {
        echo "No image found!";
    }

    // Insert the furniture details into the database
    $stmt = $mysqli->prepare("INSERT INTO furniture (name, price) VALUES (?, ?)");
    $stmt->execute([$name, $price]);

    // Display a pop-up message
    echo "<script>alert('New furniture added successfully');</script>";
}
?>

<!doctype html>
<html lang="en" class="no-js">

<head>
    <title>Add Furniture</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <link rel="stylesheet" href="css/fileinput.min.css">
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/style.css">

    <script type="text/javascript" src="js/jquery-1.11.3-jquery.min.js"></script>
    <script type="text/javascript" src="js/validation.min.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
</head>

<body>
    <?php include('includes/header.php'); ?>
    <div class="ts-main-content">
        <?php
        $aid = $_SESSION['id'];
        $ret = "SELECT * FROM admin WHERE id=?";
        $stmt = $mysqli->prepare($ret);
        $stmt->bind_param('i', $aid);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($row = $res->fetch_assoc()) {
            $superadmin = $row['superadmin'];

            // Include the appropriate sidebar file based on superadmin value
            if ($superadmin == 1) {
                include('includes/s_sidebar.php');
            } else {
                include('includes/sidebar.php');
            }
        }
        ?>
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="page-title" style="margin-top: 100px;">Add Furniture</h2>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text" name="name" id="name" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="price">Price</label>
                                                <input type="text" name="price" id="price" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="imageToUpload">Choose File</label>
                                                <input type="file" name="imageToUpload" id="imageToUpload" onchange="previewImage();" accept="image/*">
                                            </div>
                                            <div id="imagePreview"></div>
                                            <button type="submit" class="btn btn-primary" style="background-color: #e91e63;">Add</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('includes/footer.php'); ?>

    <script>
 function previewImage() {
    var previewContainer = document.getElementById('imagePreview');
    var fileInput = document.getElementById('imageToUpload');
    
 
    previewContainer.innerHTML = '';

 
    for (var i = 0; i < fileInput.files.length; i++) {
        var file = fileInput.files[i];
        var reader = new FileReader();

        reader.onload = function(event) {
            var imgElement = document.createElement('img');
            imgElement.className = 'preview-image';
            imgElement.src = event.target.result;
            
            imgElement.onload = function() {
                if (imgElement.width > 250 || imgElement.height > 250) {
                    
                    var canvas = document.createElement('canvas');
                    var ctx = canvas.getContext('2d');
                    var scaleFactor = Math.min(300 / imgElement.width, 300 / imgElement.height);
                    canvas.width = imgElement.width * scaleFactor;
                    canvas.height = imgElement.height * scaleFactor;
                    ctx.drawImage(imgElement, 0, 0, canvas.width, canvas.height);
                    previewContainer.appendChild(canvas);
                } else {
                    
                    previewContainer.appendChild(imgElement);
                }
            };
        };

        reader.readAsDataURL(file);
    }
}

    </script>

    
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>
