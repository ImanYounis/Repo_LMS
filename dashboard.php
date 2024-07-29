<?php session_start();
      function viewprojects()
      {
        require_once 'dbconnection.php';
        $conn = connectDB();

        $sql = "SELECT * FROM projects ORDER BY DueDate";

        try {
          $rows = $conn->query($sql);
          foreach ($rows as $row) {
            echo "<tr><td>" . $row['Assigned'] . "</td>";
            echo "<td>" . $row['Name'] . "</td>";
            echo "<td>" . $row['DueDate'] . "</td>";
            echo "<td>" . $row['Priority'] . "</td>";
            echo "<td align='center'><button>Edit</button><button>Delete</button></td></tr>";
          }
        } catch (PDOException $e) {
          echo "Query failed: " . $e->getMessage();
        }
        $conn = null;
      }
?>
<!DOCTYPE html>
<html>
<head>
  <title>Dashboard</title>
  <link rel="stylesheet" type="text/css" href="dashboardui.css">
</head>
<body bgcolor="lightgrey">
  <!------------header section starts------------------->
  <div class="navbar">
    <div class="logo">
      Flatable
    </div>
    <div class="menu">
      <ul>
        <li><a href="signin.php" target="blank">Dropdown</a></li>
        <li><a href="home.php">blogs</a></li>
      </ul>
    </div>
  </div>
  <!-- ------------header section ends-------------- -->
<div class="container">
  <div class="sidebar">
    <div class="logo"><?php echo $_SESSION['email']; ?></div>
    <ul class="nav">
      <li><a bgcolor="green" href="dashboard.php">Dashboard</a></li>
      <li><a href="#">Page Layouts</a></li>
      <li><a href="#">Sample Page</a></li>
      <li><a href="#">Settings</a></li>
    </ul>
  </div>

  <div class="main-content">
  <h3 bgcolor="lightgrey">Dashboard Analytics</h3>
    <h4>Projects</h4>
    <table>
      <tr>
        <th>ASSIGNED</th>
        <th>NAME</th>
        <th>DUE DATE</th>
        <th>PRIORITY LEVEL</th>
        <th>ACTION</th>
      </tr>
      <?php

      viewprojects();
      ?>
    </table>
  </div>
</div>
</body>
</html>
