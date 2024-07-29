<?php session_start();?>
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
       <!--<li><a href="configureproduct.php?functionName=viewProfile">MY PROFILE</a></li>-->
      </ul>
    </div>
  </div>
  <!-- -------------header section ends------- ----------->
  <script>
//Regular expressions for validating form inputs
    let ck_name = new RegExp('^[a-z A-Z]{3,55}$');
   let ck_fname = new RegExp('^[a-z A-Z]{3,55}$');
    let ck_email =/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
    let ck_address = /^[a-zA-Z 0-9.,-]{3,60}$/;
    let ck_adm = /^[A-Za-z]{3}[0-9]{5}$/;
    let ck_phone = /^[0][3][0-9]{9}$/;
    let ck_pwd=new RegExp('^[a-z A-Z0-9@!.%$#]{8,15}$');

    function validate() 
    {
    console.log("validate() function is running");
      let adm1 = adm.value;
      let father1=father.value;
      let address1=address.value;
      let name1 = name.value;
      let pwd1 = password.value;
      let email1 = email.value;
      let phone1 = phone.value;
      let flag = true;

      n.innerHTML = "";
      p.innerHTML = "";
      e.innerHTML = "";
      ph.innerHTML = "";
      a.innerHTML = "";
      ad.innerHTML = "";
      f.innerHTML = "";

      if (!ck_name.test(name1)) {
alert("nme check running");
        name.select();
        n.innerHTML = "Enter valid name";
        n.style.color = "red";
        n.style.fontSize = "0.85em";
        flag = false;
      }

      if (!ck_pwd.test(pwd1)) {
        password.select();
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

      if (!ck_adm.test(adm1)) 
      {
        adm.select();
        ad.innerHTML = "admission no is not in required format";
        ad.style.color = "red";
        ad.style.fontSize = "0.85em";
        flag = false;
      }

      if (!ck_fname.test(father1)) 
      {
        father.select();
        f.innerHTML = "enter valid father name";
        f.style.color = "red";
        f.style.fontSize = "0.85em";
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
alert(flag);
      return flag;
    }
  </script>
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
//-------------Admin class declaration starts-------------------------

class Admin{
       function showAll()
       {
          require_once 'dbconnection.php';
	  $conn = connectDB();

          $sql = "SELECT EmailID, Name, ContactNo, Pic FROM teacher";
          try 
          {
             $rows = $conn->query($sql);
             $a=new Admin();

   	     echo "<div style='padding:20px;'><div class='product-container'><table class='cart-table' bgcolor='white'>";
	     echo "<b><tr><td>Profile Pic</td><td>Name</td><td>EmailID</td><td>Contact</td><td>Action</td></tr></b>";
             foreach ($rows as $row) 
             {
                 $email = $row["EmailID"];
                 $name = $row["Name"];
                 $phone = $row["ContactNo"] ;
                 $img = $row["Pic"]; 

                 echo "<tr><td><img src='images/".$img."' height='80' width='80'></td>";
                 echo "<td><div class='product-title'>".$name."</div></td>";
                 echo "<td><div class='product-description'>".$email."</div></td>";
                 echo "<td><div class='product-price'>".$phone."</div></td>";
                 echo "<td align='center'><div><a class='cart-link' href='admin.php?functionName=showComplete&amp;Email=$email'>
		       View</a><br><a class='cart-link' style='margin-top: 10px;' href='admin.php?functionName=delete&amp;Email=$email'>Delete</a></div></td></tr>";
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
      function delete()
      {
	  $email=$_GET['Email'];
	  $sql="DELETE FROM teacher WHERE EmailID=:email";
	  $sql1="DELETE FROM users WHERE EmailID=:email";
	  require_once 'dbconnection.php';
	  $conn=connectDB();
	  $stmt=$conn->prepare($sql);
	  $stmt->bindParam(':email',$email);
	  $stmt->execute();
	  $stmt=$conn->prepare($sql1);
	  $stmt->bindParam(':email',$email);
	  $stmt->execute();
	  echo '<script>alert("User deleted successfully");</script>';
	  $this->showAll();
      }
	  

      function showComplete()
      {
	  $sql = "SELECT * FROM teacher WHERE EmailID = :email";

	  require_once 'dbconnection.php';
	  $conn=connectDB();
	  try
          {
	     $stmt = $conn->prepare($sql);
	     $stmt->bindParam(':email', $_GET['Email']);
	     $stmt->execute();
  	     $rows = $stmt->fetch(PDO::FETCH_ASSOC);
	   //$rows=$conn->query($sql);
	     echo "<center><div class='profile-container'><div class='profile-image'><img src='images/".$rows['Pic']."' height='150' width='150'></div>";
	     echo "<div class='profile-info'><h4>Personal Information:</h4><table bgcolor='white' class='cart-table'><tr><td>".$rows['Name']."</td><br>
		   <td>".$rows['EmailID']."</td><br><td>".$rows['ContactNo']."</td><br><td>".$rows['Address']."</td></tr></table></div>";
	     echo "<div class='profile-info'><h4>Educational Information:</h4><table bgcolor='white' class='cart-table'><tr><td>".$rows['Education']."</td></tr></table><br></div>";
	     echo "<div class='profile-info'><h4>Work Experience:</h4><table bgcolor='white' class='cart-table'><tr><td>".$rows['Experience']."</td></tr></table><br></div></div>";
	     echo '<a class="edit-link" href="admin.php?functionName=showAll">Back</a>';
          }
	  catch(PDOException $e)
	  {
	     echo "Query Failed: ".$e->getMessage();
	  }
	  $conn=null;
      }

      function displaytableform()
      {
	  $sql="SELECT EmailID, Name FROM teacher";
          echo '<form action="timetable.php" class="form-container" onsubmit="return validate();" method="post">
             <div style="width: 30em;"><div>';
	  echo '<label for="day">Choose day: *</label>
             <select name="day" id="day" size="1">
             <option value="mon">Monday</option>
             <option value="tue">Tuesday</option>
             <option value="wed">Wednesday</option>
             <option value="thu">Thursday</option>
             <option value="fri">Friday</option>
             </select><br>';
	  echo '<label for="timeslot">Choose Timeslot: *</label>
             <select name="timeslot" id="timeslot" size="1">
             <option value="1st">8:15am-9:00am</option>
             <option value="2nd">9:00am-9:45am</option>
             <option value="3rd">9:45am-10:30am</option>
             <option value="4th">10:30am-11:15am</option>
             <option value="5th">11:15am-12:00pm</option>
             <option value="6th">12:45pm-1:30pm</option>
             </select><br>';
	  echo '<label for="class">Choose class: *</label>
             <select name="class" id="class" size="1">
             <option value="6th">6th</option>
             <option value="7th">7th</option>
             <option value="8th">8th</option>
             <option value="9th">9th</option>
             <option value="10th">10th</option>
             <option value="1st year">1st year</option>
             <option value="2nd year">2nd year</option>
             </select><br>';
	  echo '<label for="subject">Choose subject: *</label>
             <select name="subject" id="subject" size="1">
             <option value="science">Science</option>
             <option value="mathematics">Mathmematics</option>
             <option value="urdu">Urdu</option>
             <option value="computerScience">Computer Science</option>
             <option value="biology">Biology</option>
             <option value="islamiat">Islamiat</option>
             <option value="english">English</option>
             </select><br>';
require_once'dbconnection.php';
$conn=connectDB();
$rows=$conn->query($sql);
	  echo '<label for="teacher">Choose Teacher: *</label><select name="teacher" id="teacher" size="1">';
foreach($rows as $row){
echo '<option value="' . $row["EmailID"] . '">' . $row['Name'] . '</option>';
}
             echo '</select><br>';
          echo '</div></form>';

       echo '<div style="clear: both;">
          <input type="submit" name="submitButton" id="submitButton" value="Add to Timetable" onclick="$this->createTimetable()" />
          <input type="reset" name="resetButton" id="resetButton" value="Reset Timetable" style="margin-right: 20px;" />
        </div>';
$conn=null;
      }

      function createTimetable()
      {
$sql = "INSERT INTO timetable (day, timeslot, subject, teacher, class) VALUES (:day, :timeslot, :subject, :teacher, :class)";


	  $day=$_POST["day"];
	  $class=$_POST["class"];
	  $timeslot=$_POST["timeslot"];
	  $teacher=$_POST["teacher"];
	  $subject=$_POST["subject"];
	  require_once 'dbconnection.php';
	  $conn = connectDB();
          try 
          {
		$stmt = $conn->prepare($sql);

	    // Bind the values to the placeholders
    		$stmt->bindParam(':teacher', $teacher);
    		$stmt->bindParam(':class', $class);
    		$stmt->bindParam(':subject', $subject);
    		$stmt->bindParam(':day', $day);
    		$stmt->bindParam(':timeslot', $timeslot);
	        $stmt->execute();

             // $rows = $conn->query($sql);
              echo "Data inserted successfully";
	      echo "<div class='profile-container'><h1>Thank You</h1>
               <p>The timetable has been updated in the database successfully.</p>
               <center><a href='admin.php?functionName=displaytableform' class='cart-link'>Back</a></div>";
            
          } 
          catch (PDOException $e) 
          {
              echo "Query failed: " . $e->getMessage();
          }
          $conn = null;
      }
      function viewtimetable()
      {
          require_once 'dbconnection.php';
	  $conn = connectDB();

          $sql = "SELECT * FROM timetable ORDER BY FIELD(day, 'mon','tue','wed','thu','fri'),timeslot,class";
	  $sql1="SELECT Name FROM teacher WHERE EmailID=:email";
          try 
          {
             $rows = $conn->query($sql);
             $a=new Admin();

   	     echo "<div style='padding:20px;'><div class='product-container'><center>TIME TABLE<table class='cart-table' bgcolor='white'>";
	     echo "<tr><th>Day</th><th>TimeSlot</th><th>Teacher</th><th>Class</th><th>Subject</th><th>Action</th></tr>";
             foreach ($rows as $row) 
             {
                 $day = $row["day"];
                 $timeslot = $row["timeslot"];
                 $teacher = $row["teacher"] ;
$stmt=$conn->prepare($sql1);
$stmt->bindParam(':email',$teacher);
$stmt->execute();
$t=$stmt->fetch(PDO::FETCH_ASSOC);
                 $class = $row["class"]; 
		 $subj=$row["subject"];
$qs=array('day'=>$day,'timeslot'=>$timeslot,'teacher'=>$t['Name'],'subj'=>$subj,'class'=>$class);
                 echo "<tr><td><div class='product-title'>".$day."</div></td>";
                 echo "<td><div class='product-title'>".$timeslot."</div></td>";
                 echo "<td><div class='product-description'>".$t['Name']."</div></td>";
                 echo "<td><div class='product-price'>".$class."</div></td>";
                 echo "<td><div class='product-price'>".$subj."</div></td>";
		 echo "<td align='center'><div><a class='cart-link' href='admin.php?functionName=editTable&" . http_build_query($qs) . "'>
		    Edit</a><br></tr>";//<a class='cart-link' style='margin-top: 10px;' href='admin.php?functionName=deleteTableRow&amp;Email=$email'>Delete</a></div></td></tr>";
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

      function editTable() 
      {
    ?>
<center>
    <h1>TimeTable Details</h1>
<?php
//-----------------code to retrieve current info of teacher unchangeable one----------------------------------------
	require_once 'dbconnection.php';
	$conn=connectDB();
	$subj=$_GET['subj'];
	$class=$_GET['class'];
	$teacher=$_GET['teacher'];
	$day=$_GET['day'];
	$time=$_GET['timeslot'];
	$sql1="SELECT EmailID, Name FROM teacher";
	//$sql1= 'SELECT Address, Pic, Education, Experience FROM teacher WHERE EmailID=:email';
?>

    <form action="etimetable.php" class="form-container" onsubmit="return validate();" method="post">
      <div style="width: 30em;"><div>
        <label for="day"><b>Day: *</b></label>
        <label class="label_form"><?php echo $day; ?></label>
        <input type="hidden" name="day" id="day" value="<?php echo $day ?>"/>
        <span id="n"></span><br>

        <label for="timeslot"><b>Timeslot: *</b></label>
        <input type="hidden" name="timeslot" id="timeslot" value="<?php echo $time ?>"/>
        <label class="label_form"><?php echo $time; ?></label>
        <span id="e"></span><br>

        <label for="class"><b>Class: *</b></label>
        <input type="hidden" name="class" id="class" value="<?php echo $class ?>"/>
        <label class="label_form"><?php echo $class; ?></label>
        <span id="p"></span><br></div>

        <!--<label for="teacher"><b>Teacher: *</b></label>
        <input type="text" name="teacher" id="teacher" value="<?php echo $teacher; ?>"/>
        <span id="ph"></span><br>

        <label for="address"><b>Your Address: *</b></label>
        <input type="text" name="address" id="address" value="<?php echo $address; ?>"/>
        <span id="a"></span><br>-->

        <label for="subject">Subject: *</label>
        <select name="subject" id="subject" size="1">
             <option value="<?php echo $subj;?>"><?php echo $subj;?></option>
             <option value="science">Science</option>
             <option value="mathematics">Mathmematics</option>
             <option value="urdu">Urdu</option>
             <option value="computerScience">Computer Science</option>
             <option value="biology">Biology</option>
             <option value="islamiat">Islamiat</option>
             <option value="english">English</option>
        </select><br>
<?php
require_once'dbconnection.php';
$conn=connectDB();
$rows=$conn->query($sql1);
	  echo '<label for="teacher">Teacher: *</label><select name="teacher" id="teacher" size="1">';
	  echo '<option value="<?php echo $teacher;?>"><?php echo $teacher;?></option>';
foreach($rows as $row){
echo '<option value="' . $row["EmailID"] . '">' . $row['Name'] . '</option>';
}
             echo '</select><br>';
?>
        <div style="clear: both;">
          <input type="submit" name="submitButton" id="submitButton" value="Edit Row" onclick="$this->editedtable()" />
          <input type="reset" name="resetButton" id="resetButton" value="Reset Row" style="margin-right: 20px;" />
        </div>
      </div>
    </form>
    <?php
        }

        function editedtable() 
        {
	  $sql = 'UPDATE timetable SET teacher=:teacher,subject=:subj WHERE day=:day AND timeslot=:time AND class=:class';
          $day = $_POST["day"];
          $time = $_POST["timeslot"];
          $class= $_POST["class"];
          $subj = $_POST["subject"];
          $teacher = $_POST["teacher"];

	  require_once 'dbconnection.php';
	  $conn = connectDB();

          try 
          {

		$stmt = $conn->prepare($sql);
	        $stmt->bindParam(':class', $class);
    		$stmt->bindParam(':day', $day);
    		$stmt->bindParam(':time', $time);
    		$stmt->bindParam(':subj', $subj);
    		$stmt->bindParam(':teacher', $teacher);
	        $stmt->execute();

             // $rows = $conn->query($sql);
              echo "Data inserted successfully";
	      echo "<div class='profile-container'><h1>Thank You</h1>
               <p>The Timetable has been updated in the database successfully.</p><center>
	       <a href='admin.php?functionName=viewtimetable' class='cart-link'>Back</a><br></div>";
            
          } 
          catch (PDOException $e) 
          {
              echo "Query failed: " . $e->getMessage();
          }
          $conn = null;
       }
       function registerStd()
       {
?>
<center>
    <h1>Student Registeration Form</h1>
    <p>Please fill in student's details below and click Register Student. Fields marked with an asterisk (*) are required.</p>
    <form action="stdregisteration.php" class="form-container" onsubmit="return validate();" method="post">

        <label for="adm"><b>Student Admission No: *</b></label>
        <input type="text" name="adm" id="adm" value=""/>
        <span id="ad"></span><br>

        <label for="name"><b>Student Name: *</b></label>
        <input type="text" name="name" id="name" value=""/>
        <span id="n"></span><br>

        <label for="father"><b>Father Name: *</b></label>
        <input type="text" name="father" id="father" value=""/>
        <span id="f"></span><br>

        <label for="phone"><b>Student ContactNo: *</b></label>
        <input type="text" name="phone" id="phone" value=""/>
        <span id="ph"></span><br>

        <label for="address"><b>Student Address: *</b></label>
        <input type="text" name="address" id="address" value=""/>
        <span id="a"></span><br>

       <label for="class">Choose class of student: *</label>
        <select name="class" id="class" size="1">
          <option value="6th">6th</option>
          <option value="7th">7th</option>
          <option value="8th">8th</option>
          <option value="9th">9th</option>
          <option value="10th">10th</option>
          <option value="1st year">1st year</option>
          <option value="2nd year">2nd year</option>
        </select><br>

        <label for="email"><b>Student login Username: *</b></label>
        <input type="text" name="email" id="email" value=""/>
        <span id="e"></span><br>

        <label for="password"><b>Student Password: *</b></label>
        <input type="password" size="31" name="password" id="password" value=""/>
        <span id="p"></span><br>
          <input type="submit" name="submitButton" id="submitButton" value="Register Student"/>
          <input type="reset" name="resetButton" id="resetButton" value="Clear Form" style="margin-right: 20px;" />
      </div>
    </form>
    <?php
       }
       function registeredStd()
       {
 	  $email=$_POST['email'];
          $name = $_POST["name"];
          $class = $_POST["class"];
          $pwd = $_POST["password"];
          //$desig = $_POST["designation"];
          $father = $_POST["father"];
          $address = $_POST["address"];
          $adm = $_POST["adm"];
          $phone = $_POST["phone"];
	  $role="student";

	  require_once 'dbconnection.php';
	  $conn = connectDB();

        //Running sql queries to save data in database
	$sql2="SELECT * FROM student WHERE AdmissionNo=:adm OR Username=:email";
        $sql = "INSERT INTO users(EmailID,ContactNo,Username,Password,Role)VALUES(:email,:phone,:name,:pwd,:role)";
        $sql1 = "INSERT INTO student(AdmissionNo,Name,FatherName,Class,Address,ContactNo,Username,Password)VALUES(:adm,:name,:father,:class,:address,:phone,:email,:pwd)";
          try 
          {
		$stmt = $conn->prepare($sql2);
	        $stmt->bindParam(':adm', $adm);
	        $stmt->bindParam(':email', $email);
	        $stmt->execute();
	        $rows=$stmt->fetch(PDO::FETCH_ASSOC);
if($rows)
{ echo 'Student is already registered';return;}
else{try{
		$stmt1 = $conn->prepare($sql1);
	    // Bind the values to the placeholders
	        $stmt1->bindParam(':name', $name);
	        $stmt1->bindParam(':email', $email);
    		$stmt1->bindParam(':father', $father);
    		$stmt1->bindParam(':class', $class);
    		$stmt1->bindParam(':adm', $adm);
    		$stmt1->bindParam(':phone', $phone);
    		$stmt1->bindParam(':address', $address);
                $stmt1->bindParam(':pwd', $pwd);
	
	    // Execute the prepared statement
	        $stmt1->execute();

		$stmt2 = $conn->prepare($sql);
	        $stmt2->bindParam(':name', $name);
	        $stmt2->bindParam(':role', $role);
	        $stmt2->bindParam(':email', $email);
    		$stmt2->bindParam(':pwd', $pwd);
    		$stmt2->bindParam(':phone', $phone);
		$stmt2->execute();
             // $rows = $conn->query($sql);
              echo "Data inserted successfully";
	      echo "<div class='profile-container'><h1>Success</h1>
               <p>Student has been registered successfully.</p><center>
	       <a href='admin.php?functionName=registerStd' class='cart-link'>Back</a></div>";
}catch(PDOException $e){
echo "Query Failed:". $e->getMessage();
}
}            
          } 
          catch (PDOException $e) 
          {
              echo "Query failed: " . $e->getMessage();
          }
          $conn = null;
       }
}
//-------------class declaration ends-------------------------
    if (isset($_GET['functionName'])) 
    {
       $functionName = $_GET['functionName'];

       if (method_exists('Admin', $functionName)) 
       {
          $a = new Admin();
          $a->$functionName(); // Invoke the function dynamically
       }
    }
?>
</div>
</div>
</body>
</html>