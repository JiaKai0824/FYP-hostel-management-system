<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();

// Check if sorting parameters are set
$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : '';
$sort_order = isset($_GET['sort_order']) ? $_GET['sort_order'] : '';

// Set default sorting if parameters are not set
if (empty($sort_by) || empty($sort_order)) {
    $sort_by = 'lec_id'; // Default column to sort by
    $sort_order = 'asc'; // Default sort order
}

if (isset($_GET['del'])) {
    $lec_id = $_GET['del'];
    $adn = "DELETE FROM lecturer WHERE lec_id=?";
    $stmt = $mysqli->prepare($adn);
    $stmt->bind_param('s', $lec_id);
    $stmt->execute();
    $stmt->close();
    echo "<script>alert('Data Deleted');</script>";
}

if (isset($_GET['disable'])) {
    $lec_id = $_GET['disable'];
    $disable_query = "UPDATE lecturer SET status = 0 WHERE lec_id = ?";
    $stmt = $mysqli->prepare($disable_query);
    $stmt->bind_param('s', $lec_id);
    $stmt->execute();
    $stmt->close();
    echo "<script>alert('Lecturer disabled successfully');</script>";
}

if (isset($_GET['enable'])) {
    $lec_id = $_GET['enable'];
    $enable_query = "UPDATE lecturer SET status = 1 WHERE lec_id = ?";
    $stmt = $mysqli->prepare($enable_query);
    $stmt->bind_param('s', $lec_id);
    $stmt->execute();
    $stmt->close();
    echo "<script>alert('Lecturer enabled successfully');</script>";
}


$query = "SELECT * FROM lecturer";
$params = array();

if (isset($_GET['lec_id'])) {
    $lec_id = $_GET['lec_id'];
    $query .= " WHERE lec_id = ?";
    $params[] = $lec_id;
}

$sort_column = '';
if ($sort_by == 'no') {
    $sort_column = 'lec_id';
} elseif ($sort_by == 'lecturer_name') {
    $sort_column = 'lec_name';
} else {
    $sort_column = 'lec_id';
}

$query .= " ORDER BY $sort_column $sort_order";
$stmt = $mysqli->prepare($query);

// Bind parameters if they exist
if (!empty($params)) {
    $types = str_repeat('s', count($params)); // Assuming all parameters are strings, adjust if necessary
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

?>

<!doctype html>
<html lang="en" class="no-js">

<head>
    <title>Manage Lecturers</title>
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-social.css">
    <link rel="stylesheet" href="css/bootstrap-select.css">
    <link rel="stylesheet" href="css/fileinput.min.css">
    <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
    <link rel="stylesheet" href="css/style.css">
    <script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
    <style>
        .page-title {
            margin-top: 50px;
        }
    </style>
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
                        <h1 class="page-title"><br>Manage Lecturer</h1>
                        <div class="panel panel-default">
                            <div class="panel-heading">All Lecturers Details</div>
                            <div class="panel-body">
                                <form action="" method="GET">
                                    <input type="text" name="lec_id" placeholder="Search by Lecturer ID">
                                    <input type="submit" value="Search">
                                </form>
                                <br>
                                <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>
                                                    Lecturer ID
                                                    <?php if (isset($_GET['sort_by']) && $_GET['sort_by'] == 'lec_id' && isset($_GET['sort_order']) && $_GET['sort_order'] == 'asc') { ?>
                                                    <a href="manage-lecturer.php?sort_by=student_id&sort_order=desc">
                                                    <i class="fa fa-sort-up"></i>
                                                    </a>
                                                    <?php } elseif (isset($_GET['sort_by']) && $_GET['sort_by'] == 'lec_id' && isset($_GET['sort_order']) && $_GET['sort_order'] == 'desc') { ?>
                                                    <a href="manage-lecturer.php?sort_by=lec_id&sort_order=asc">
                                                    <i class="fa fa-sort-down"></i>
                                                    </a>
                                                    <?php } else { ?>
                                                    <a href="manage-lecturer.php?sort_by=lec_id&sort_order=asc">
                                                    <i class="fa fa-sort"></i>
                                                    </a>
                                                    <?php } ?>
                                            </th>
                                            <th>
                                                Lecturer Name
                                                <?php if (isset($_GET['sort_by']) && $_GET['sort_by'] == 'lec_name' && isset($_GET['sort_order']) && $_GET['sort_order'] == 'asc') { ?>
                                                <a href="manage-lecturer.php?sort_by=student_name&sort_order=desc">
                                                <i class="fa fa-sort-up"></i>
                                                </a>
                                                <?php } elseif (isset($_GET['sort_by']) && $_GET['sort_by'] == 'lec_name' && isset($_GET['sort_order']) && $_GET['sort_order'] == 'desc') { ?>
                                                <a href="manage-lecturer.php?sort_by=lec_name&sort_order=asc">
                                                <i class="fa fa-sort-down"></i>
                                                </a>
                                                <?php } else { ?>
                                                <a href="manage-lecturer.php?sort_by=lec_name&sort_order=asc">
                                                <i class="fa fa-sort"></i>
                                                </a>
                                            <?php } ?>  
                                            </th>
                                            <th>Email</th>
                                            <th>Contact Number</th>
                                            
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    
                                    <tfoot>
                                        <tr>
                                            <th>No.</th>
                                            <th>Lecturer ID</th>
                                            <th>Lecturer Name</th>
                                            <th>Email</th>
                                            <th>Contact Number</th>
                                           
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        $cnt = 1;
                                        if (mysqli_num_rows($result) > 0) {
                                         
                                            while ($row = mysqli_fetch_array($result)) {
                                                ?>
                                                <tr>
                                                <td><?php echo $cnt; ?></td>
                                                    <td><?php echo ($row['lec_id']); ?></td>
                                                    <td><?php echo ($row['lec_name']); ?></td>
                                                    <td><?php echo ($row['lec_email']); ?></td>
                                                  
                                                    <td><?php echo ($row['lec_phone']); ?></td>
                                                
                                                    <td>
                                                        <a href="edit-lecturer.php?lec_id=<?php echo ($row['lec_id']); ?>">
                                                            <i class="fa fa-edit"></i>
                                                        </a>&nbsp;&nbsp;
                                                        <a href="manage-lecturer.php?del=<?php echo $row['lec_id']; ?>" title="Delete Record" onclick="return confirm('Do you want to delete?')">
														<i class="fa fa-trash-o"></i>
                                                        </a>&nbsp;&nbsp;
                                                            <?php if ($row['status'] == 1) { ?>
                                                            <a href="manage-lecturer.php?disable=<?php echo htmlentities($row['lec_id']); ?>" onclick="return confirm('Are you sure you want to disable this lecturer?');">
                                                            <i class="fa fa-ban"></i>
                                                            </a>
                                                            <?php } else { ?>
                                                            <a href="manage-lecturer.php?enable=<?php echo htmlentities($row['lec_id']); ?>" onclick="return confirm('Are you sure you want to enable this lecturer?');">
                                                            <i class="fa fa-check-circle"></i>
                                                        </a>
                                                        <?php } ?>
                                                    </td>   
                                                </tr>
                                            <?php
                                            $cnt++;
                                            }
                                        } else {
                                            echo "<tr><td colspan='7'>No data found</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Scripts -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap.min.js"></script>
    <script src="js/Chart.min.js"></script>
    <script src="js/fileinput.js"></script>
    <script src="js/chartData.js"></script>
    <script src="js/main.js"></script>
</body>
<?php include('includes/footer.php'); ?>
</html>
