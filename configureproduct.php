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
<body bgcolor="lightgrey">
<!----------------------header section starts-------------->
  <div class="navbar">
    <div class="logo">
      LMS
    </div>
    <div class="menu">
      <ul>
        <li><a href="signin.php" target="blank">SIGNIN </a></li>
        <li><a href="home.php">HOME</a></li>
        <li><a href="configureproduct.php?functionName=viewProfile">MY PROFILE</a></li>
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
       <a class="cart-link" href="student.php?functionName=viewSchedule" style="margin-bottom:10px;">View my class schedule</a><br></div>';
}
?>

  <div class="main-content">
    <h3 align="center">DASHBOARD</h3>
  <?php
//-------------------teacher class declaration-----------------------------------------------------
    class Teacher
    {
      function viewProfile()
      {
	  $sql = "SELECT * FROM teacher WHERE EmailID = :email";

	  require_once 'dbconnection.php';
	  $conn=connectDB();
	  try
          {
	     $stmt = $conn->prepare($sql);
	     $stmt->bindParam(':email', $_SESSION['email']);
	     $stmt->execute();
  	     $rows = $stmt->fetch(PDO::FETCH_ASSOC);
	   //$rows=$conn->query($sql);
if($rows){
	     echo "<center><div class='profile-container'><div class='profile-image'><img src='images/".$rows['Pic']."' height='150' width='150'></div>";
	     echo "<div class='profile-info'><h4>Personal Information:</h4><table bgcolor='white' class='cart-table'><tr><td>".$rows['Name']."</td><br>
		   <td>".$rows['EmailID']."</td><br><td>".$rows['ContactNo']."</td><br><td>".$rows['Address']."</td></tr></table><br></div>";
	     echo "<div class='profile-info'><h4>Educational Information:</h4><table bgcolor='white' class='cart-table'><tr><td>".$rows['Education']."</td></tr></table><br></div>";
	     echo "<div class='profile-info'><h4>Work Experience:</h4><table bgcolor='white' class='cart-table'><tr><td>".$rows['Experience']."</td></tr></table><br></div></div>";
	     echo '<a class="edit-link" href="configureproduct.php?functionName=displayForm">Edit Profile</a>';
}
else{
echo "no record found";
}
          }
	  catch(PDOException $e)
	  {
	     echo "Query Failed: ".$e->getMessage();
	  }
	  $conn=null;
      }
      function displayForm() 
      {
    ?>
<center>
    <h1>Profile Details</h1>
    <p>Please fill in your details below and click Update Profile. Fields marked with an asterisk (*) are required.</p>
<?php
//-----------------code to retrieve current info of teacher unchangeable one----------------------------------------
	require_once 'dbconnection.php';
	$conn=connectDB();
	$email=$_SESSION["email"];
	$sql = 'SELECT Username, Password, ContactNo FROM users WHERE EmailID = :email AND Role = "teacher"';
	$sql1= 'SELECT Address, Pic, Education, Experience FROM teacher WHERE EmailID=:email';
	$stmt = $conn->prepare($sql);
	$stmt->bindParam(':email', $email);
	$stmt->execute();

	$rows = $stmt->fetch(PDO::FETCH_ASSOC);
	//----------for query2-----------------
	$stmt2 = $conn->prepare($sql1);
	$stmt2->bindParam(':email', $email);
	$stmt2->execute();

	$rows2 = $stmt2->fetch(PDO::FETCH_ASSOC);
	//-----------end for query2-------------
	$name=$rows['Username'];
	$phone=$rows['ContactNo'];
	$pwd=$rows['Password'];
	$address=null;$edu=null;$exp=null;$img=null;
	if($rows2!==false){
		$img=$rows2['Pic'];
		$address=$rows2['Address'];
		$edu=$rows2['Education'];
		$exp=$rows2['Experience'];
	}
	$conn=null;
//-------------------------done-----------------------------------------------------------------------
?>

    <form action="updateprofile.php" class="form-container" onsubmit="return validate();" method="post" enctype="multipart/form-data">
      <div style="width: 30em;"><div>
        <label for="name"><b>Your Name: *</b></label>
        <label class="label_form"><?php echo $name; ?></label>
        <span id="n"></span><br>

        <label for="email"><b>Email ID: *</b></label>
        <!--<input type="text" name="email" id="email" value="<?php echo $_SESSION['email']; ?>"/>-->
        <label class="label_form"><?php echo $email; ?></label>
        <span id="e"></span><br>

        <label for="password"><b>Your Password: *</b></label>
        <!--<input type="password" size="31" name="password" id="password" value="<?php echo $pwd; ?>"/>-->
        <label class="label_form"><?php echo $pwd; ?></label>
        <span id="p"></span><br></div>

        <label for="phone"><b>Your ContactNo: *</b></label>
        <input type="text" name="phone" id="phone" value="<?php echo $phone; ?>"/>
        <span id="ph"></span><br>

        <label for="address"><b>Your Address: *</b></label>
        <input type="text" name="address" id="address" value="<?php echo $address; ?>"/>
        <span id="a"></span><br>

       <!-- <label for="designation">Choose designation: *</label>
        <select name="category" id="category" size="1">
          <option value="principal">Culinary</option>
          <option value="hm">Edible</option>
          <option value="pro">Lamps</option>
          <option value="lecturer">Lamps</option>
        </select><br>-->

        <label for="edu"><b>Enter Educational Details: *</b></label><br>
        <textarea name="edu" id="edu" rows="4" cols="50"><?php echo $edu; ?></textarea>
        <span id="ed"></span><br>

        <label for="image"><b>Enter image filename with extension: *</b></label>
        <!--<input type="text" name="image" id="image" value="<?php echo $img?>"/><br>-->
<input type="hidden" name="MAX_FILE_SIZE" value="5500000">
<input type="file" name="image" value="">

        <label for="exp"><b>Enter Experience Details: *</b></label>
        <textarea name="exp" id="exp" rows="4" cols="50"><?php echo $exp; ?></textarea>
        <span id="x"></span><br>

        <div style="clear: both;">
          <input type="submit" name="submitButton" id="submitButton" value="Update Profile" onclick="$this->displayThanks()" />
          <input type="reset" name="resetButton" id="resetButton" value="Reset Profile" style="margin-right: 20px;" />
        </div>
      </div>
    </form>
    <?php
        }

        function displayThanks() 
        {
	  $email=$_SESSION['email'];
         // $name = $_POST["name"];
          $exp = $_POST["exp"];
         // $pwd = $_POST["password"];
          //$desig = $_POST["designation"];
          $edu = $_POST["edu"];
          $address = $_POST["address"];
         // $img = $_POST["image"];
          $phone = $_POST["phone"];


//----------------trying to use input file field-----------------
	$img=$_FILES["image"]["name"];
    	$tempname = $_FILES["image"]["tmp_name"];
	echo $_FILES["image"]["tmp_name"];
	    $folder = "images/" . $img;
	if($_FILES["image"]["size"]>10000)
	die("file too big");
if ($_FILES["image"]["error"] !== 0) {
    die("File upload error. Error code: " . $_FILES["image"]["error"]);
}

    	if (move_uploaded_file($tempname, $folder)) {
     	   echo "<h3>  Image uploaded successfully!</h3>";
    	} else {
           echo "<h3>  Failed to upload image!</h3>";
    	}
//-------------------------------end of try-------------------


	  require_once 'dbconnection.php';
	  $conn = connectDB();

        //Running sql queries to save data in database
        //$sql = "INSERT INTO teacher(Name,EmailID,Experience,Pic,Education,ContactNo,Address,Password)VALUES(:name,:email,:exp,:img,:edu,:phone,:address,:pwd)";
	  $sql= "UPDATE teacher SET ContactNo=:phone, Pic=:img, Address=:address, Education=:edu, Experience=:exp WHERE EmailID=:email";

          try 
          {

		$stmt = $conn->prepare($sql);

	    // Bind the values to the placeholders
	      //$stmt->bindParam(':name', $name);
	        $stmt->bindParam(':email', $email);
    		$stmt->bindParam(':exp', $exp);
    		$stmt->bindParam(':img', $img);
    		$stmt->bindParam(':edu', $edu);
    		$stmt->bindParam(':phone', $phone);
    		$stmt->bindParam(':address', $address);
              //$stmt->bindParam(':pwd', $pwd);
	
	    // Execute the prepared statement
	        $stmt->execute();

             // $rows = $conn->query($sql);
              echo "Data inserted successfully";
	      echo "<div class='profile-container'><h1>Thank You</h1>
               <p>Your information has been updated in the database successfully.</p></div>";
            
          } 
          catch (PDOException $e) 
          {
              echo "Query failed: " . $e->getMessage();
          }
          $conn = null;
       }
      function viewmytable()
      {
          require_once 'dbconnection.php';
	  $conn = connectDB();

          $sql = "SELECT day,class,subject,timeslot FROM timetable WHERE teacher=:email ORDER BY FIELD(day,'mon','tue','wed','thu','fri'),timeslot";
	 // $sql1="SELECT Name FROM teacher WHERE EmailID=:email";
          try 
          {
$stmt=$conn->prepare($sql);
$stmt->bindParam(':email',$_SESSION['email']);
$stmt->execute();
$rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
             //$rows = $conn->query($sql);
             //$a=new Admin();

   	     echo "<div style='padding:20px;'><div class='product-container'><center>MY TIME TABLE<table class='cart-table' bgcolor='white'>";
	     echo "<tr><th>Day</th><th>TimeSlot</th><th>Class</th><th>Subject</th></tr>";
             foreach ($rows as $row) 
             {
                 $day = $row["day"];
                 $timeslot = $row["timeslot"];
                 //$teacher = $row["teacher"] ;

                 $class = $row["class"]; 
		 $subj=$row["subject"];

                 echo "<tr><td><div class='product-title'>".$day."</div></td>";
                 echo "<td><div class='product-title'>".$timeslot."</div></td>";
                 //echo "<td><div class='product-description'>".$t['Name']."</div></td>";
                 echo "<td><div class='product-price'>".$class."</div></td>";
                 echo "<td><div class='product-price'>".$subj."</div></td></tr>";
                // echo "<td align='center'><div><a class='cart-link' href='admin.php?functionName=showComplete&amp;Email=$email'>
		       //View</a><br><a class='cart-link' style='margin-top: 10px;' href='admin.php?functionName=delete&amp;Email=$email'>Delete</a></div></td></tr>";
             }
             echo "</table>";
             echo "</div>";
	     echo "</div>";
          } 
          catch (PDOException $e) 
          {
             echo "Query failed: " . $e->getMessage();
          }
          $conn = null;

      }
    }
//-----------------class definition ends----------------------------------

    if (isset($_GET['functionName'])) 
    {
       $functionName = $_GET['functionName'];

       if (method_exists('Teacher', $functionName)) 
       {
          $t = new Teacher();
          $t->$functionName(); // Invoke the function dynamically
       }
    }
//$t=new Teacher();
//$t->displayThanks();
//$t->showProduct();
  ?>
</div>
</div>
  <script>
//Regular expressions for validating form inputs
    let ck_name = new RegExp('^[a-z A-Z]{3,40}$');
    let ck_edu = new RegExp('^[a-z A-Z0-9.,%\-_()]{3,}$');
    let ck_address = /^[a-zA-Z 0-9.,-]{3,60}$/;
    let ck_exp = new RegExp('^[a-z A-Z0-9.,%_()\-]{3,}$');
    
	
//name, adderess, qualification, exp, designation, pic,email,contat,name,pwd,dept,skills

    function validate() 
    {
      let name1 = name.value;
      let edu1 = edu.value;
      let exp1=exp.value;
      let address1=address.value;

      let flag = true;
      n.innerHTML = "";
      ed.innerHTML = "";
      x.innerHTML = "";
      a.innerHTML = "";

      if (!ck_name.test(name1)) 
      {
        name.select();
        n.innerHTML = "Enter valid name";
        n.style.color = "red";
        n.style.fontSize = "0.85em";
        flag = false;
      }

      if (!ck_edu.test(edu1)) 
      {
        edu.select();
        ed.innerHTML = "education details can't have special characters";
        ed.style.color = "red";
        ed.style.fontSize = "0.85em";
        flag = false;
      }

      if (!ck_exp.test(exp1)) 
      {
        exp.select();
        x.innerHTML = "exp cannot have special characters or numbers";
        x.style.color = "red";
        x.style.fontSize = "0.85em";
        flag = false;
      }

      if (!ck_address.test(address1)) 
      {
        address.select();
        a.innerHTML = "address should be proper";
        a.style.color = "red";
        a.style.fontSize = "0.85em";
        flag = false;
      }
      return flag;
    }
  </script>
</body>
</html>
