<?php session_start();?>

<!DOCTYPE html>
<html>
<head>
  <title>Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta charset="utf8">
  <!--<link rel="stylesheet" href="stylesheet.css">-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="dashboardui.css">
</head>

<body bgcolor="lightgrey">
  <!------------header section starts------------------->
  <div class="navbar">
    <div class="logo">
	LMS
    </div>
    <div class="menu">
      <ul>
        <li><a href="signin.php" target="blank">SIGNIN </a></li>
        <li><a href="home.php">HOME</a></li>
      </ul>
    </div>
  </div>
  <!-- ------------header section ends-------------- -->
<div class="container">
<?php
$role=$_SESSION['role'];
if($role==="admin"){
    echo '<center><div style="margin-top:20px;" class="sidebar"><h3 style="margin-bottom:40px;">Welcome to the Admin Dashboard</h3><br>
       <a class="cart-link" href="admin.php?functionName=showAll" style="margin-bottom:10px;">View All Teachers</a><br>
       <a class="cart-link" href="admin.php?functionName=displaytableform" style="margin-bottom:10px;">Create Timetable</a><br>
       <a class="cart-link" href="admin.php?functionName=viewtimetable" style="margin-bottom:10px;">View Timetable</a><br>
       <a class="cart-link" href="admin.php?functionName=registerStd" style="margin-bottom:10px;">Register Student</a><br></div>';
}
else if($role==="teacher"){
    echo '<center><div style="margin-top:20px;" class="sidebar"><h3 style="margin-bottom:40px;">Welcome to the Teacher Dashboard</h3><br>
       <a class="cart-link" href="configureproduct.php?functionName=viewProfile" style="margin-bottom:10px;">Go to my Profile</a><br>
       <a class="cart-link" href="configureproduct.php?functionName=viewmytable" style="margin-bottom:10px;">View my Timetable</a><br></div>';
}
else if($role==="student"){
     echo '<center><div style="margin-top:20px;" class="sidebar"><h3 style="margin-bottom:40px;">Welcome to the Student Dashboard</h3><br>
       <a class="cart-link" href="student.php?functionName=viewSchedule" style="margin-bottom:10px;">View my class schedule</a><br></div>';
}
?>
</div>
</body>
</html>