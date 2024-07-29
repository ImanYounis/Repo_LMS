<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta charset="utf8">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="style.css">

</head>
<body bgcolor="#F3CFC6">
<!----------------------header section starts-------------->
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
  <!-- -------------header section ends------- ----------->
<div class="container">
<?php
$role=$_SESSION['role'];
if($role==="admin"){
    echo '<div class="sidebar"><h3 style="margin-bottom:40px;">Welcome to the Admin Dashboard</h3><br>
       <a href="admin.php?functionName=showAll" style="margin-bottom:10px;">View All Teachers</a><br>
       <a href="admin.php?functionName=displaytableform" style="margin-bottom:10px;">Create Timetable</a><br>
       <a href="admin.php?functionName=viewtimetable" style="margin-bottom:10px;">View Timetable</a><br>
       <a href="admin.php?functionName=registerStd" style="margin-bottom:10px;">Register Student</a><br></div>';
}
else if($role==="teacher"){
    echo '<div class="sidebar"><h3 style="margin-bottom:40px;">Welcome to the Teacher Dashboard</h3><br>
       <a href="configureproduct.php?functionName=viewProfile" style="margin-bottom:10px;">Go to my Profile</a><br>
       <a href="configureproduct.php?functionName=viewmytable" style="margin-bottom:10px;">View my Timetable</a><br></div>';
}
else if($role==="student"){
     echo '<div class="sidebar"><h3 style="margin-bottom:40px;">Welcome to the Student Dashboard</h3><br>
       <a href="student.php?functionName=viewSchedule" style="margin-bottom:10px;">View my class schedule</a><br></div>';
}
?>

  <div class="main-content">
    <h3 align="center">DASHBOARD</h3>
  <?php
//-------------------student class declaration-----------------------------------------------------
    class Student
    {
      function viewSchedule()
      {
	  $sql1="SELECT Class FROM student WHERE Username=:email";
	  $sql = "SELECT * FROM timetable WHERE class= :class";

	  require_once 'dbconnection.php';
	  $conn=connectDB();
	  try
          {
	     $stmt = $conn->prepare($sql1);
	     $stmt->bindParam(':email', $_SESSION['email']);
	     $stmt->execute();
  	     $rows = $stmt->fetch(PDO::FETCH_ASSOC);
	   //$rows=$conn->query($sql);
	     $stmt1 = $conn->prepare($sql);
	     $stmt1->bindParam(':class', $rows["Class"]);
	     $stmt1->execute();
  	     $rows1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

$sql3="SELECT Name FROM teacher WHERE EmailID=:email";

   	     echo "<div style='padding:20px;'><div class='product-container'><center>MY TIME TABLE<table class='cart-table' bgcolor='white'>";
	     echo "<tr><th>Day</th><th>TimeSlot</th><th>Class</th><th>Subject</th></tr>";
             foreach ($rows1 as $row) 
             {
                 $day = $row["day"];
                 $timeslot = $row["timeslot"];
                 //$teacher = $row["teacher"] ;

                 $teacher = $row["teacher"];

		 $subj=$row["subject"];
$stmt2=$conn->prepare($sql3);
	     $stmt2->bindParam(':email', $teacher);
	     $stmt2->execute();
  	     $t = $stmt2->fetch(PDO::FETCH_ASSOC);
                 echo "<tr><td><div class='product-title'>".$day."</div></td>";
                 echo "<td><div class='product-title'>".$timeslot."</div></td>";
                 echo "<td><div class='product-description'>".$t['Name']."</div></td>";
                 //echo "<td><div class='product-price'>".$teacher."</div></td>";
                 echo "<td><div class='product-price'>".$subj."</div></td></tr>";
                // echo "<td align='center'><div><a class='cart-link' href='admin.php?functionName=showComplete&amp;Email=$email'>
		       //View</a><br><a class='cart-link' style='margin-top: 10px;' href='admin.php?functionName=delete&amp;Email=$email'>Delete</a></div></td></tr>";
             }
             echo "</table>";
             echo "</div>";
	     echo "</div>";
          }
	  catch(PDOException $e)
	  {
	     echo "Query Failed: ".$e->getMessage();
	  }
	  $conn=null;
      }
    }
//-----------------class definition ends----------------------------------

    if (isset($_GET['functionName'])) 
    {
       $functionName = $_GET['functionName'];

       if (method_exists('Student', $functionName)) 
       {
          $s = new Student();
          $s->$functionName(); // Invoke the function dynamically
       }
    }
?>
</div>
</div>
</body>
</html>