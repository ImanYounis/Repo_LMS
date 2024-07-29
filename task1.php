<?php session_start();?>

<!DOCTYPE html>
<html>
<head>
  <title>Dashboard</title>
  <link rel="stylesheet" href="style1.css">
</head>

<body>
<?php
     if (isset($_POST["submitButton"]))
        changepwd();
     else
        forgotpwd();

function forgotpwd(){
//$username=$_GET['username'];
  ?>

<div class="container">
    <h1>Reset Password</h1>
    <form method="post">
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" placeholder="New Password" name="npwd" required>

      <input type="password" placeholder="Confirm Password" name="pwd" required>
      <button name="submitButton" type="submit">Change Password</button>
      <div class="links">
       <p><a href="task.php">Go Back</a></p>

      </div>
    </form>
</div>
<?php
}
     function changepwd()
     {
       //if(isset($_POST["loginbtn"])){
         $flag = false;
$username=$_POST["username"];
        // $lemail = $_POST["email"];
         $lpwd = $_POST["pwd"];
         $npwd = $_POST["npwd"];
if($lpwd!==$npwd){
echo "<script>alert('new password and confirm passwords not the same');</script>";
forgotpwd();
return;
}
	 //$role=$_POST["role"];

	require_once 'dbconnection.php';
	$conn = connectDB();
         $sql1l = "SELECT * FROM users WHERE Username='$username'";
         try 
         {

            $rows = $conn->query($sql1l);
            if ($rows->rowCount() > 0) 
            {
              // echo "Login was successful";
            //   $_SESSION['email'] = $lemail;
$sql2="UPDATE users SET Password='$lpwd'WHERE Username='$username'";
$rows1=$conn->query($sql2);
echo "<div class='container'>Password updated successfully. You can now login!
<div class='links'><a href='task.php'>Login</a></div></div>";
               $flag = true;
            } 
            else 
            {
        //echo '<script>alert("The password or email you entered is incorrect. Please retry!");</script>';
	echo '<p style="color:red;">Username not found in database</p>';
	    }
         } 
         catch (PDOException $e)
         {
            echo "Query failed: " . $e->getMessage();
         }
         $conn = null;
     }

?>
</body>
</html>