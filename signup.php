<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Signup</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta charset="utf8">
  <link rel="stylesheet" href="style.css">
  
</head>
<body>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body bgcolor="#F3CFC6">
  <!------------header starts----------------->
  <div class="navbar">
    <div class="logo">
     LMS
    </div>
    <div class="menu">
      <ul>
        <li><a href="signin.php" target="blank">SIGNIN </a></li>
       <!-- <li><a href="#">HOME</a></li>-->
      </ul>
    </div>
  </div>
  <!-- ---------header section ends---------- -->
  <div class="main">
    <p align="center">SIGN UP</p>
  </div>


<?php
if (isset($_POST["submitButton"])) {
  processForm();
} else {
  displayForm(array());
}

function validateField($fieldName, $missingFields)
{
  if (in_array($fieldName, $missingFields)) {
    echo ' class="error"';
  }
}

function setValue($fieldName)
{
  if (isset($_POST[$fieldName])) {
    echo $_POST[$fieldName];
  }
}

function setSelected($fieldName, $fieldValue)
{
  if (isset($_POST[$fieldName]) && $_POST[$fieldName] == $fieldValue) {
    echo ' selected="selected"';
  }
}

function processForm()
{
  $requiredFields = array("name", "pwd", "phone", "email", "role");
  $missingFields = array();

  foreach ($requiredFields as $requiredField) {
    if (!isset($_POST[$requiredField]) || !$_POST[$requiredField]) {
      $missingFields[] = $requiredField;
    }
  }

  if ($missingFields) {
    displayForm($missingFields);
  } else {
    displayThanks();
  }
}

function displayForm($missingFields)
{
  ?>
<center>
  <h1>Sign Up Form</h1>

  <?php if ($missingFields) { ?>
    <p class="error">There were some problems with the form you submitted. Please complete the fields highlighted below and click Send Details to resend the form.</p>
  <?php } else { ?>
    <p>To signup, please fill in your details below and click Send Details. Fields marked with an asterisk (*) are required.</p>
  <?php } ?>

  <form action="signup.php" class="form-container" onsubmit="return validate();" method="post">
    <div style="width: 30em;">
      <label for="name"<?php validateField("name", $missingFields) ?>><b>Your Name: *</b></label>
      <input type="text" name="name" id="name" value="<?php setValue('name') ?>" /><span id="n"></span><br>

      <label for="pwd"<?php validateField("pwd", $missingFields) ?>><b>Enter password:*</b></label>
      <input type="password" size="31" name="pwd" id="pwd" value="" /><span id="p"></span><br>

      <label for="email"<?php validateField("email", $missingFields) ?>><b>Enter your email ID: *</b></label>
      <input type="text" name="email" id="email" value="<?php setValue('email') ?>" /><span id="e"></span><br>

      <label for="role"><b>Select your role:*</b></label>
      <select name="role" id="role" size="1">
        <option value="teacher"<?php setSelected("role", "teacher") ?>>Teacher</option>
        <option value="admin"<?php setSelected("role", "admin") ?>>Administrator</option>
      </select><br>

      <label for="phone"<?php validateField("phone", $missingFields) ?>><b>Enter your Phone No: *</b></label>
      <input type="text" name="phone" id="phone" value="<?php setValue('phone') ?>"/><span id="ph"></span><br>


      <div style="clear: both;">
        <input type="submit" name="submitButton" id="submitButton" value="Send Details" />
        <input type="reset" name="resetButton" id="resetButton" value="Reset Form" style="margin-right: 20px;" />
      </div>
      Already have an account?<a style="height: 45px; width: 70px; background-color:#f7f7f7; color:black;" href="signin.php"><b>  Login</b></a>
    </div>
  </form>
  <?php
}

function displayThanks()
{
  $flag = false;
  $name = $_POST["name"];
  $pwd = $_POST["pwd"];
  $email = $_POST["email"];
  $phone = $_POST["phone"];
  $role = $_POST["role"];

	require_once 'dbconnection.php';
	$conn = connectDB();

  $sql1 = "SELECT * FROM users WHERE Username='$name' AND EmailID='$email'";

  $sql = "INSERT INTO users(Username,Password,ContactNo,EmailID,Role) VALUES('$name','$pwd','$phone','$email','$role')";
  $sql2="INSERT INTO teacher(Name,Password,EmailID,ContactNo) VALUES('$name','$pwd','$email','$phone')";
  try {

      $exists = $conn->query($sql1);

    if ($exists->rowCount() !== 0) {
      echo "user already exists. Please login!";
      $flag = true;
    } else {
        $rows = $conn->query($sql);
	if($role==="teacher"){
	   $rows2=$conn->query($sql2);
	   //echo "data inserted in teachers table too";
	}
      echo " Data inserted successfully";
    }
  } catch (PDOException $e) {
    echo "Query failed: " . $e->getMessage();
  }

  $conn = null;

  if ($flag)
    displayForm(array());
  else
    signedup();
}

function signedup()
{
  ?>
  <div class='profile-container'><h1>Success!</h1>
  <p>Thank you, your data has been successfully saved in the database.</p>
  <a class="cart-link" href="signin.php">Please login into your account</a></div>
  <?php
}
?>
<script>
    let ck_name = new RegExp('^[a-z A-Z]{3,35}$');
    let ck_pwd = new RegExp('^[a-z A-Z0-9@!.%$#]{8,15}$');
    let ck_email = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
    let ck_phone = /^[0][3][0-9]{9}$/;

    function validate() {
      let name1 = name.value;
      let pwd1 = pwd.value;
      let email1 = email.value;
      let phone1 = phone.value;
      let flag = true;

      n.innerHTML = "";
      p.innerHTML = "";
      e.innerHTML = "";
      ph.innerHTML = "";

      if (!ck_name.test(name1)) {
        name.select();
        n.innerHTML = "Enter valid name";
        n.style.color = "red";
        n.style.fontSize = "0.85em";
        flag = false;
      }

      if (!ck_pwd.test(pwd1)) {
        pwd.select();
        p.innerHTML = "password must me at least 8 characters long";
        p.style.color = "red";
        p.style.fontSize = "0.85em";
        flag = false;
        //alert("checking pwd condition");
      }
      if (!ck_email.test(email1)) {
        email.select();
        e.innerHTML = "enter valid email id";
        e.style.color = "red";
        e.style.fontSize = "0.85em";
        flag = false;
      }

      if (!ck_phone.test(phone1)) {
        phone.select();
        ph.innerHTML = "must be in format: 03123456789";
        ph.style.color = "red";
        ph.style.fontSize = "0.85em";
        flag = false;
      }
      return flag;
    }
  </script>
</body>
</html>