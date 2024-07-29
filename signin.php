<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta charset="utf8">
  <!--<link rel="stylesheet" href="stylesheet.css">-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="style.css">
</head>

<body bgcolor="#F3CFC6">
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

  <?php
     if (isset($_POST["loginbtn"]))
        displaythanks();
     else
        displayform();

     function displayform()
     {
  ?>
    <div class="main">
      <p align="center">LOGIN</p>
    </div>
    <table align="center" height="80%" width="50%" style="margin-left: auto; margin-right: auto;">
      <form method="post" align="center">
        <div class="signin" align="center">
          <tr align="center">
            <td><label for="lemail" class="label_form">Enter Email: *</label><br></td>
          </tr>
          <tr align="center">
            <td><input type="text" name="lemail" id="email" value="" size=30 style="height: 45px;" class="input_form" /><br></td>
          </tr>
          <tr align="center">
            <td><label for="lpwd" class="label_form">Enter Password:*</label><br></td>
          </tr>
          <tr align="center">
            <td><input type="password" name="lpwd" id="pwd" value="" size=30 style="height: 45px;" class="input_form" /><br></td>
          </tr>
          <tr align="center">
            <td><label for="role" class="label_form">Choose Role:*</label><br></td>
          </tr>
  	  <tr align="center">
            <td><select name="role" id="role"><option value="student">Student</option><option value="admin">Admin</option><option value="teacher">Teacher</option></select><br></td>
          </tr>

          <tr align="center">
            <td><input type="submit" name="loginbtn" value="Login" style="height: 45px; width: 70px; background-color:#f7f7f7; color:black;" class="input_form"><br></td>
          </tr>
        </div>
      </form>
    <table>

    <p align="center" style="font-family: 'Times New Roman', Times, serif; font-size: 1.1rem;">Haven't registered yet? Please signup<br><p>
    <p align="center" style="font-family: 'Times New Roman', Times, serif; font-size: 1.1rem;"><a href="signup.php" style="color: black; font-weight:bold">Sign Up</a></p>
  <?php	
     }

     function displaythanks()
     {
       //if(isset($_POST["loginbtn"])){
         $flag = false;
         $lemail = $_POST["lemail"];
         $lpwd = $_POST["lpwd"];
	 $role=$_POST["role"];

	require_once 'dbconnection.php';
	$conn = connectDB();
         $sql1l = "SELECT * FROM users WHERE Password='$lpwd' AND EmailID='$lemail' AND Role='$role'";
         try 
         {

            $rows = $conn->query($sql1l);
            if ($rows->rowCount() > 0) 
            {
               echo "Login was successful";
               $_SESSION['email'] = $lemail;
               $_SESSION['role'] = $role;
               $flag = true;
            } 
            else 
            {
        echo '<script>alert("The password or email you entered is incorrect. Please retry!");</script>';
	echo '<p style="color:red;">the password or email is incorrect. Please Retry!</p>';
	    }
         } 
         catch (PDOException $e)
         {
            echo "Query failed: " . $e->getMessage();
         }
         $conn = null;
         if ($flag)
            loggedin($role);
         else
            displayform();
     }

     function loggedin($role)
     {
         if (isset($_SESSION["email"]))
            echo '<center><h1>Login Successful!</h1>
            <p>Your login was successful. Welcome to the '.$role.' Dashboard!</p><br>';
	    if($role==="teacher"){
	       echo '<a class="cart-link" href="configureproduct.php?functionName=viewProfile" style="margin-bottom:10px;">Go to my Profile</a><br>';
	       echo '<a class="cart-link" href="configureproduct.php?functionName=viewmytable" style="margin-bottom:10px;">View my Timetable</a><br>';
	    }
	    else if($role==="admin"){
	       echo '<a class="cart-link" href="admin.php?functionName=showAll" style="margin-bottom:10px;">View All Teachers</a><br>';
	       echo '<a class="cart-link" href="admin.php?functionName=displaytableform" style="margin-bottom:10px;">Create Timetable</a><br>';
	       echo '<a class="cart-link" href="admin.php?functionName=viewtimetable" style="margin-bottom:10px;">View Timetable</a><br>';
	       echo '<a class="cart-link" href="admin.php?functionName=registerStd" style="margin-bottom:10px;">Register Student</a><br>';
	    }
	    else if($role==="student"){
	       echo '<a class="cart-link" href="student.php?functionName=viewSchedule" style="margin-bottom:10px;">View my class schedule</a><br>';
	    }
     }
  ?>
</body>
</html>
