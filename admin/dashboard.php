<?php
session_start();
include('includes/config.php');
include('includes/checklogin.php');
check_login();

$query = "SELECT MONTH(payment_date) AS month, SUM(amount) AS total_amount FROM payments GROUP BY MONTH(payment_date)";
$result = mysqli_query($mysqli, $query);

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $month = date('M', mktime(0, 0, 0, $row['month'], 1));
    $amount = $row['total_amount'];
    $data[$month] = $amount;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Boxicons -->
  <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
  <!-- My CSS -->
  <link rel="stylesheet" href="style.css">

  <title>Dashboard</title>

  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="css/bootstrap-social.css">
  <link rel="stylesheet" href="css/bootstrap-select.css">
  <link rel="stylesheet" href="css/fileinput.min.css">
  <link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
  <link rel="stylesheet" href="css/style.css">
  
  <link rel="stylesheet" type="text/css" href="hostel.css">
  <script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>

  <style>
    body {
      font-size: 16px;
    }

    h1, h2, h3, h4, h5, h6 {
      font-size: 24px;
    }

	.ts-main-content .logo {
  	  margin-bottom: 20px; 
	}

	.ts-main-content .logo a {
  	  padding: 10px; 
	}

	.grid-item .logo {
      margin-left: auto;
  	}

	.fa.fa-arrow-right {
  	  transform: translateX(3cm);
	}

  .head-title {
  margin-top: 150px;
}

.left h1 {
  margin-top: 0; 
}

.ts-main-content {
  margin-top: -100px; 
}

canvas {
  max-width: 800px;
  margin: 0 auto;
  display: block;
  border: 1px solid #ccc;
  height: 300px;
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

<section id="content">
  <main>
    <div class="head-title">
      <div class="left">
        <h1>Dashboard</h1>
        <ul class="breadcrumb">
          <li>
            <a href="#">Dashboard</a>
          </li>
          <li><i class='bx bx-chevron-right'></i></li>
          <li>
            <a class="active" href="manage-students.php">(STUDENTS)</a>
            <a class="active" href="manage-lecturer.php">(LECTURER)</a>
            <a class="active" href="manage-rooms.php">(ROOM)</a>
          </li>
        </ul>
      </div>
    </div>

    <ul class="box-info">
      <li>
	  <?php
$result ="SELECT count(*) FROM student_information	 ";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();
?>	
        <div class="grid-item">
          <i class="bx bxs-group"></i>
          <span class="text">
            <div class="number">&nbsp;&nbsp;&nbsp;<?php echo $count ?></div>
            <div class="card-name">&nbsp;&nbsp;&nbsp;Students</div>
          </span>
          <a href="manage-students.php" class="arrow-link">
            <i class="fa fa-arrow-right"></i>
          </a>
        </div>
      </li>
      <li>
	  <?php
$result2 ="SELECT count(*) FROM lecturer ";
$stmt2 = $mysqli->prepare($result2);
$stmt2->execute();
$stmt2->bind_result($count2);
$stmt2->fetch();
$stmt2->close();
?>	
        <div class="grid-item">
          <i class="bx bxs-group"></i>
          <span class="text">
            <div class="number">&nbsp;&nbsp;&nbsp;<?php echo $count2; ?></div>
            <div class="card-name">&nbsp;&nbsp;&nbsp;Lecturer</div>
          </span>
          <a href="manage-lecturer.php" class="arrow-link">
            <i class="fa fa-arrow-right"></i>
          </a>
        </div>
      </li>
      <li>
	  <?php
$result1 ="SELECT count(*) FROM rooms ";
$stmt1 = $mysqli->prepare($result1);
$stmt1->execute();
$stmt1->bind_result($count1);
$stmt1->fetch();
$stmt1->close();
?>
        <div class="grid-item">
          <i class="bx bxs-calendar-check"></i>
          <span class="text">
            <div class="number">&nbsp;&nbsp;&nbsp;<?php echo $count1; ?></div>
            <div class="card-name">&nbsp;&nbsp;&nbsp;Rooms</div>
          </span>
          <a href="manage-rooms.php" class="arrow-link">
            <i class="fa fa-arrow-right"></i>
          </a>
        </div>
      </li>
    </ul>
    <h2 style="text-align: center;">Total Income Graph</h2>
    <canvas id="graphCanvas"></canvas>
  </main>
</section>


<style>
  .box-info li {
    display: flex;
    align-items: center;
  }

  .grid-item {
    display: flex;
    align-items: center;
  }

  .grid-item .arrow-link {
    margin-left: auto;
    display: inline-block;
    color: inherit;
    text-decoration: none;
  }
</style>

      <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
      
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  
      <script src="js/jquery.min.js"></script>
      <script src="js/bootstrap-select.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
      <script src="js/jquery.dataTables.min.js"></script>
      <script src="js/dataTables.bootstrap.min.js"></script>
      <script src="js/Chart.min.js"></script>
      <script src="js/fileinput.js"></script>
      <script src="js/chartData.js"></script>
      <script src="js/main.js"></script>
      <script src="script.js"></script>
      <script>
    $(document).ready(function() {
      var data = <?php echo json_encode($data); ?>;
      var months = Object.keys(data);
      var amounts = Object.values(data);

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
            x: {
              beginAtZero: true,
              display: true,
              title: {
                display: true,
                text: 'Month'
              },
              ticks: {
                autoSkip: true,
                maxTicksLimit: 12
              }
            },
            y: {
              beginAtZero: true,
              display: true,
              title: {
                display: true,
                text: 'Amount '
              },
              ticks: {
                max: 10000,
                stepSize: 1000,
                callback: function(value, index, values) {
                  return 'RM  ' + value.toFixed(0);
                }
              }
            }
          }
        }
      });
    });
  </script>
    </div>
</body>
<?php include('includes/footer.php'); ?>
</html>
