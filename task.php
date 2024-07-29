<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
  <title>Login Page</title>
  <link rel="stylesheet" type="text/css" href="style1.css">
</head>
<body>
<!--
  <div class="container">
    <h1>Sign Up</h1>
    <form method="post" action="tasksignup.php">
      <input type="text" placeholder="Username" name="username" required>
      <input type="text" placeholder="Email" name="email" required>

      <input type="password" placeholder="Password" name="password" required>
      <label>
        <input type="checkbox" name="newsletter"> Send me the newsletter weekly
      </label>
      <button type="submit">Sign up</button>
      <div class="links">
       <p>Already have an account?<a href="#">SignIn</a></p>

      </div>
    </form>
  </div>-->

  <?php
     if (isset($_POST["loginbtn"]))
        displaythanks();
     else
        displayform();

     function displayform()
     {
  ?>
  <div class="container">
    <h1>SignIn</h1>
    <form method="post">
      <input type="text" placeholder="Username" name="lemail" required>
      <input type="password" placeholder="Password" name="lpwd" required>
      <label>
        <input type="checkbox" name="saveCredentials"> Save credentials
      </label>
      <button name="loginbtn" type="submit">SignIn</button>
      <div class="links">
        <p>Forgot password?<a href="task1.php">Reset</a></p>
       <p>Don't have an account?<a href="tasksignup.php">SignUp</a></p>

      </div>
    </form>
  </div>
  <?php	
     }

     function displaythanks()
     {
       //if(isset($_POST["loginbtn"])){
         $flag = false;
         $lemail = $_POST["lemail"];
         $lpwd = $_POST["lpwd"];
	 //$role=$_POST["role"];

	require_once 'dbconnection.php';
	$conn = connectDB();
         $sql1l = "SELECT * FROM users WHERE Password='$lpwd' AND Username='$lemail'";
         try 
         {

            $rows = $conn->query($sql1l);
            if ($rows->rowCount() > 0) 
            {
              // echo "Login was successful";
               $_SESSION['email'] = $lemail;
              // $_SESSION['role'] = $role;
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
            loggedin();
         else
            displayform();
     }

     function loggedin()
     {
         if (isset($_SESSION["email"]))
            echo '<div class="container"><h1>Login Successful!</h1>
            <p>Your login was successful. Welcome to your Dashboard!</p></div>';
	    if($role==="teacher"){
	      header("Location:configureproduct.php");
	      
	    }
	    else if($role==="admin"){
	      header("Location:admin.php");
	    }
	    else if($role==="student"){
	      header("Location:student.php");
	    }
     }
  ?>
</body>
</html>
