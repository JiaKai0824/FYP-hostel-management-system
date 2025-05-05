<?php
include('includes/config.php');

$query = "SELECT MONTH(payment_date) AS month, SUM(amount) AS total_amount FROM payment GROUP BY MONTH(payment_date)";
$result = mysqli_query($mysqli, $query);

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $month = $row['month'];
    $amount = $row['total_amount'];
    $data[$month] = $amount;
}

mysqli_close($mysqli);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Payment Graph</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <canvas id="graphCanvas"></canvas>

    <script>
        $(document).ready(function() {
            var data = <?php echo json_encode($data); ?>;
            var months = [];
            var amounts = [];
            for (var month in data) {
                months.push(month);
                amounts.push(data[month]);
            }

            var ctx = document.getElementById('graphCanvas').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'Total Amount',
                        data: amounts,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</body>

</html>
