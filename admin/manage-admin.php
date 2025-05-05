<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();

if (isset($_GET['del'])) 
{
    $id = intval($_GET['del']);
    $adn = "delete from admin where id=?";
    $stmt = $mysqli->prepare($adn);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    echo "<script>alert('Data Deleted');</script>";
}
if (isset($_GET['disable'])) {
    $id = intval($_GET['disable']);
    $disable_query = "UPDATE admin SET status = 0 WHERE id = ?";
    $stmt = $mysqli->prepare($disable_query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    echo "<script>alert('Admin disabled successfully');</script>";
}

if (isset($_GET['enable'])) {
    $id = intval($_GET['enable']);
    $enable_query = "UPDATE admin SET status = 1 WHERE id = ?";
    $stmt = $mysqli->prepare($enable_query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    echo "<script>alert('Admin enabled successfully');</script>";
}
$query = "SELECT * FROM admin";
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query .= " WHERE id LIKE '%$id%'";
}

$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : '';
$sort_order = isset($_GET['sort_order']) ? $_GET['sort_order'] : '';


if (empty($sort_by) || empty($sort_order)) {
    $sort_by = 'id';
    $sort_order = 'asc';
}

$sort_column = '';
if ($sort_by == 'no') {
    $sort_column = 'id'; 
} elseif ($sort_by == 'username') {
    $sort_column = 'username';
} else {
   
    $sort_column = 'id';
}


$query .= " ORDER BY $sort_column $sort_order";

$result = mysqli_query($mysqli, $query);
?>

<!doctype html>
<html lang="en" class="no-js">

<head>
    <title>Manage Admin</title>
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
        <?php include('includes/s_sidebar.php'); ?>
    
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-title"><br>Manage Admin</h1>
                        <div class="panel panel-default">
                            <div class="panel-heading">All Admins Details</div>
                            <div class="panel-body">
                                <form action="" method="GET">
                                    <input type="text" name="id" placeholder="Search by Admin ID">
                                    <input type="submit" value="Search">
                                </form>
                                <br>
                                <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Admin ID
                                            <?php if (isset($_GET['sort_by']) && $_GET['sort_by'] == 'id' && isset($_GET['sort_order']) && $_GET['sort_order'] == 'asc') { ?>
                                            <a href="manage-admin.php?sort_by=id&sort_order=desc">
                                            <i class="fa fa-sort-up"></i>
                                            </a>
                                            <?php } elseif (isset($_GET['sort_by']) && $_GET['sort_by'] == 'id' && isset($_GET['sort_order']) && $_GET['sort_order'] == 'desc') { ?>
                                            <a href="manage-admin.php?sort_by=id&sort_order=asc">
                                            <i class="fa fa-sort-down"></i>
                                            </a>
                                            <?php } else { ?>
                                            <a href="manage-admin.php?sort_by=id&sort_order=asc">
                                            <i class="fa fa-sort"></i>
                                            </a>
                                            <?php } ?>
                                            </th>
                                            <th>Admin Name
                                            <?php if (isset($_GET['sort_by']) && $_GET['sort_by'] == 'username' && isset($_GET['sort_order']) && $_GET['sort_order'] == 'asc') { ?>
                                                <a href="manage-admin.php?sort_by=student_name&sort_order=desc">
                                                <i class="fa fa-sort-up"></i>
                                                </a>
                                                <?php } elseif (isset($_GET['sort_by']) && $_GET['sort_by'] == 'username' && isset($_GET['sort_order']) && $_GET['sort_order'] == 'desc') { ?>
                                                <a href="manage-admin.php?sort_by=username&sort_order=asc">
                                                <i class="fa fa-sort-down"></i>
                                                </a>
                                                <?php } else { ?>
                                                <a href="manage-admin.php?sort_by=username&sort_order=asc">
                                                <i class="fa fa-sort"></i>
                                                </a>
                                            <?php } ?>  
                                                </th>
                                            <th>Email</th>                                    
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    
                                    <tfoot>
                                        <tr>
                                        <th>No.</th>
                                            <th>Admin ID</th>
                                            <th>Admin Name</th>
                                            <th>Email</th>
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
                                                    <td><?php echo ($row['id']); ?></td>
                                                    <td><?php echo ($row['username']); ?></td>
                                                    <td><?php echo ($row['email']); ?></td>
                                                  
                                            
                                                    <td>
                                                        <a href="edit-admin.php?id=<?php echo ($row['id']); ?>">
                                                            <i class="fa fa-edit"></i>
                                                        </a>&nbsp;&nbsp;
                                                        <a href="manage-admin.php?del=<?php echo $row['id']; ?>" title="Delete Record" onclick="return confirm('Do you want to delete?')">
														<i class="fa fa-trash-o"></i>
                                                        </a>&nbsp;&nbsp;
                                                            <?php if ($row['status'] == 1) { ?>
                                                            <a href="manage-admin.php?disable=<?php echo htmlentities($row['id']); ?>" onclick="return confirm('Are you sure you want to disable this admin?');">
                                                            <i class="fa fa-ban"></i>
                                                            </a>
                                                            <?php } else { ?>
                                                            <a href="manage-admin.php?enable=<?php echo htmlentities($row['id']); ?>" onclick="return confirm('Are you sure you want to enable this admin?');">
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
