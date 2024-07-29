<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Signup Page</title>
  <link rel="stylesheet" type="text/css" href="style1.css">
</head>
<body>
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

function processForm()
{
  $requiredFields = array("name", "pwd", "email");
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

<div class="container">
    <h1>Sign Up</h1>
    <form method="post" action="tasksignup.php">
      <input type="text" placeholder="Username" name="name" required>
      <input type="text" placeholder="Email" name="email" required>

      <input type="password" placeholder="Password" name="pwd" required>
      <label>
        <input type="checkbox" name="newsletter"> Send me the newsletter weekly
      </label>
      <button name="submitButton" type="submit">Sign up</button>
      <div class="links">
       <p>Already have an account?<a href="task.php">SignIn</a></p>

      </div>
    </form>
</div>

  <?php
}

function displayThanks()
{
    $flag = false;
    $name = $_POST["name"];
    $pwd = $_POST["pwd"];
    $email = $_POST["email"];

    require_once 'dbconnection.php';
    $conn = connectDB();

    $sql1 = "SELECT * FROM users WHERE Username='$name' AND EmailID='$email'";
    $sql = "INSERT INTO users(Username, Password, EmailID) VALUES('$name', '$pwd', '$email')";

    try {
        $exists = $conn->query($sql1);

        if ($exists->rowCount() !== 0) {
            echo "User already exists. Please login!";
            $flag = true;
        } else {
            $rows = $conn->query($sql);
            echo "Data inserted successfully";
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
  <div class='container'><h1>Success!</h1>
  <p>Thank you, your data has been successfully saved in the database.</p>
  <div class="links"><a href="task.php">Please login into your account</a></div></div>
  <?php
}
?>
<script>
    let ck_name = new RegExp('^[a-z A-Z]{3,35}$');
    let ck_pwd = new RegExp('^[a-z A-Z0-9@!.%$#]{8,15}$');
    let ck_email = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
    function validate() {
      let name1 = name.value;
      let pwd1 = pwd.value;
      let email1 = email.value;
      let flag = true;

      n.innerHTML = "";
      p.innerHTML = "";
      e.innerHTML = "";

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

      return flag;
    }
  </script>
</body>
</html>