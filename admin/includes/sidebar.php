<!DOCTYPE html>
<html>
<head>
<style>
body {
  margin: 0;
  font-family: Verdana, Arial, Helvetica, sans-serif;
}

.ts-sidebar {
  margin: 0;
  padding: 0;
  width: 100px;
  background: #222;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
  position: fixed;
  height: 100%;
  overflow: auto;
  padding: 10px;
  z-index: 2;
}

.ts-sidebar a {
  display: block;
  color: white;
  padding: 16px;
  text-decoration: none;
  font-size: 15px;
}
 
.ts-sidebar a.active {
  background-color: #222;
  color: white;
}

.ts-sidebar a:hover:not(.active) {

  color: white;
}

.ts-content {
  margin-left: 200px;
  padding: 1px 16px;
  height: 1000px;
}

@media screen and (max-width: 700px) {
  .ts-sidebar {
    width: 100%;
    height: auto;
    position: relative;
  }
  .ts-sidebar a {float: left;}
  .ts-content {margin-left: 0;}
}

@media screen and (max-width: 400px) {
  .ts-sidebar a {
    text-align: center;
    float: none;
  }
}
.ts-profile {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-bottom: 20px;
}

.ts-avatar {
  width: 80px;
  height: 80px;
  border-radius: 50%;
  margin-bottom: 10px;
}

.ts-title {
  font-size: 24px;
  color: white;
  margin: 0;
  text-transform: uppercase;
}

</style>
</head>
<body>
<div class="ts-separator"></div>
<nav class="ts-sidebar">
  <div class="ts-profile"><br>
    <img src="img/ts-avatar.jpg" class="ts-avatar">

    <h3 class="ts-title">ADMIN</h3>
  </div>
  <ul class="ts-sidebar-menu">
  <div class="ts-separator"></div>
    <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="#"><i class="fa fa-graduation-cap" aria-hidden="true"></i> Student</a>
      <ul>
        <li><a href="registration_student.php">Student Registration</a></li>
        <li><a href="manage-students.php">Manage Student</a></li>
      </ul>
    </li>
    <li><a href="#"><i class="fa fa-users" aria-hidden="true"></i> Lecturer</a>
      <ul>
        <li><a href="registration_lecturer.php">Lecturer Registration</a></li>
        <li><a href="manage-lecturer.php">Manage Lecturer</a></li>
      </ul>
    </li>
    <li><a href="#"><i class="fa fa-bed" aria-hidden="true"></i> Rooms</a>
      <ul>
        <li><a href="create-room.php">Add a Room</a></li>
        <li><a href="manage-rooms.php">Manage Rooms</a></li>
      </ul>
    </li>
    <li><a href="add-furniture.php"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Add Furniture</a></li>
    <li><a href="booking-history.php"><i class="fa fa-users"></i> Booking History</a></li>
    <li><a href="payment.php"><i class="fa fa-file" aria-hidden="true"></i> Payment Report</a></li>  
  </ul>
  <div class="ts-separator"></div>
</nav>
</body>
</html>
