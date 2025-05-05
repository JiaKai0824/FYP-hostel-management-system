<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();

if (isset($_GET['del'])) {
    $id = intval($_GET['del']);
    $adn = "DELETE FROM bookings WHERE id=?";
    $stmt = $mysqli->prepare($adn);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    echo "<script>alert('Data Deleted');</script>";
}

$query = "SELECT b.booking_id, b.booking_type, b.block, b.room_number, b.room_id, b.start_date, b.end_date, b.status, u.user_id, u.user_type, u.full_name
        FROM bookings b
        INNER JOIN user_details u ON b.user_id = u.user_id";

if (isset($_GET['booking_id'])) {
    $booking_id = $_GET['booking_id'];
    $query .= " WHERE booking_id LIKE '%$booking_id%'";
}

$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'block';
$sort_order = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'ASC';

$query .= " ORDER BY $sort_by $sort_order";

$result = $mysqli->query($query);
?>

<!doctype html>
<html lang="en" class="no-js">

<head>
    <title>Booking History</title>
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
                        <h1 class="page-title"><br>Booking Record</h1>
                        <div class="panel panel-default">
                            <div class="panel-heading">Booking History</div>
                            <div class="panel-body">
                                <form action="" method="GET">
                                    <input type="text" name="booking_id" placeholder="Search by Booking ID">
                                    <input type="submit" value="Search">
                                </form>
                                <br>
                                <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Booking ID</th>
                                            <th>Block</th>
                                            <th>Room Number</th>
                                            <th>Room ID</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>User ID</th>
                                            <th>User Type</th>
                                            <th>Full Name</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>

                                    <tfoot>
                                        <tr>
                                            <th>No.</th>
                                            <th>Booking ID</th>
                                            <th>Block</th>
                                            <th>Room Number</th>
                                            <th>Room ID</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>User ID</th>
                                            <th>User Type</th>
                                            <th>Full Name</th>
                                            <th>Status</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        $cnt = 1;
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $cnt; ?></td>
                                                    <td><?php echo $row['booking_id']; ?></td>
                                                    <td><?php echo $row['block']; ?></td>
                                                    <td><?php echo $row['room_number']; ?></td>
                                                    <td><?php echo $row['room_id']; ?></td>
                                                    <td><?php echo $row['start_date']; ?></td>
                                                    <td><?php echo $row['end_date']; ?></td>
                                                    <td><?php echo $row['user_id']; ?></td>
                                                    <td><?php echo $row['user_type']; ?></td>
                                                    <td><?php echo $row['full_name']; ?></td>
                                                    <td><?php echo $row['status']; ?></td>
                                                </tr>
                                            <?php
                                            $cnt++;
                                            }
                                        } else {
                                            echo "<tr><td colspan='12'>No data found</td></tr>";
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
