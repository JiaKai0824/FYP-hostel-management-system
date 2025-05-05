<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();

$query = "SELECT payment_id, user_id, booking_id, payment_date, amount FROM payments";
$result = mysqli_query($mysqli, $query);

?>

<!doctype html>
<html lang="en" class="no-js">

<head>
    <title>Payment Details</title>
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
                        <h1 class="page-title"><br>Payment</h1>
                        <div class="panel panel-default">
                            <div class="panel-heading">Payment Details</div>
                            <div class="panel-body">

                                <br>
                                <table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Payment ID</th>
                                            <th>User ID</th>
                                            <th>Booking ID</th>
                                            <th>Payment Date</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>

                                    <tfoot>
                                        <tr>
                                            <th>No.</th>
                                            <th>Payment ID</th>
                                            <th>User ID</th>
                                            <th>Booking ID</th>
                                            <th>Payment Date</th>
                                            <th>Amount</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        $cnt = 1;
                                        if ($result && mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_array($result)) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $cnt; ?></td>
                                                    <td><?php echo ($row['payment_id']); ?></td>
                                                    <td><?php echo ($row['user_id']); ?></td>
                                                    <td><?php echo ($row['booking_id']); ?></td>
                                                    <td><?php echo ($row['payment_date']); ?></td>
                                                    <td><?php echo ($row['amount']); ?></td>

                                                </tr>
                                            <?php
                                            $cnt++;
                                            }
                                        } else {
                                            echo "<tr><td colspan='6'>No data found</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <input type="month" id="selectedMonth" name="selectedMonth">
                                <button id="printBtn" onclick="printPDF()">Print Report</button>
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

    <script>
        function printPDF() {
            var selectedMonth = document.getElementById("selectedMonth").value;
            window.open('generate_pdf.php?month=' + selectedMonth, '_blank');
        }
    </script>
</body>
<?php include('includes/footer.php'); ?>
</html>
