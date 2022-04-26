<!DOCTYPE html>
<html lang = "en">
<head>
<br>
    <img src="images/jayhawk.png" class="rounded float-start offset-1" height=50 width=50>
    <h1 class="header offset-1">&nbsp;Office of the University Registrar</h1>
    <link href="style.css" rel="stylesheet" type="text/css"/>
    <br>
    <h4 class="header offset-1">&nbsp; &nbsp; Schedule of Classes:</h4>
    <meta charset="UTF-8">
    <meta name="viewport" width="device-width" initial-scale="1.0">
    <title>647 Final Project Prototype</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet" type="text/css"/>
</head>
  <body class = "p-3 mb-2 bg-dark text-white align-center">
    <form class="form-horizontal" role="form" method="post" action="form.php">
       <div class="row offset-1">
          <div class="col">
              <input type="text" name="class_code" id="class_code" class="form-control" placeholder="(search text)" aria-label="Class Name">
          </div>
          <div class = "col">
              <select class="form-select form-select-md mb-3" name="class_type" id = "class_type" aria-label=".form-select-lg example">
                  <option value="Undergraduate">Undergraduate</option>
                  <option value="Graduate">Graduate</option>
                  <option value="Law">Law</option>
                  <option value="Medecine">Medecine</option>
                </select>
              </div>
          <div class = "col">
          <select class="form-select form-select-md mb-3" name="class_term" id = "class_term" aria-label=".form-select-lg example">
              <option value="Spring 2022">Spring 2022</option>
              <option value="Fall 2022">Fall 2022</option>
              <option value="Spring 2023">Spring 2023</option>
            </select>
          </div>
          <div class = "col">
              <select class="form-select form-select-md mb-3" name="class_instruction_type" id = "class_instruction_type" aria-label=".form-select-lg example">
                  <option value="Any Instruction Mode">Any Instruction Mode</option>
                  <option value="In-Person">In-Person</option>
                  <option value="Online Course">Online Courses</option>
                  <option value="Hybrid Online">Hybrid Online</option>
                  <option value="Video Courses">Video Courses</option>
                </select>
              </div>
          <div class="col">
              <button type="submit" class="btn btn-primary">Search</button>

          </div>
        </form>
      </div>

      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
  </body>
</html>

<?php

    $class_code = $_POST["class_code"];
    $class_type = $_POST["class_type"];
    $class_term = $_POST["class_term"];
    $class_instruction_type = $_POST["class_instruction_type"];
    echo "<h3>";
    echo "<br>Searching For: <br>";
    echo "<br>Class Code: " . $class_code . "<br>";
    echo "Class Type: " . $class_type . "<br>";
    echo "Class Code: " . $class_term . "<br>";
    echo "Class Type: " . $class_instruction_type . "<br> </h3>";

    $mysqli = new mysqli("mysql.eecs.ku.edu", "p162g473", "ahH3hohi", "p162g473");

    if($mysqli->connect_error){
      die("Connection failed: " . $mysqli->connect_error);
    }
    if($class_code == "" && $class_instruction_type == "Any Instruction Mode"){
      $query = "SELECT ClassCode, PROFESSOR.name, BuildingName, RoomNumber, CreditHours, SeatsAvailable, Time, Mode FROM CLASS, TEACHES, PROFESSOR WHERE CLASS.ClassNumber = TEACHES.ClassNumber
                AND PROFESSOR.PID = TEACHES.PID";
    }
    else if($class_code != "" && $class_instruction_type == "Any Instruction Mode"){
      $query = "SELECT ClassCode, PROFESSOR.name, BuildingName, RoomNumber, CreditHours, SeatsAvailable, Time, Mode FROM CLASS, TEACHES, PROFESSOR WHERE ClassCode LIKE '%$class_code%'
                AND CLASS.ClassNumber = TEACHES.ClassNumber
                AND PROFESSOR.PID = TEACHES.PID";
    }
    else if($class_code == "" && $class_instruction_type != "Any Instruction Mode"){
      $query = "SELECT ClassCode, PROFESSOR.name, BuildingName, RoomNumber, CreditHours, SeatsAvailable, Time, Mode FROM CLASS, TEACHES, PROFESSOR WHERE CLASS.Mode='$class_instruction_type'
                AND CLASS.ClassNumber = TEACHES.ClassNumber
                AND PROFESSOR.PID = TEACHES.PID";
    }
    else{
      $query = "SELECT ClassCode, PROFESSOR.name, BuildingName, RoomNumber, CreditHours, SeatsAvailable, Time, Mode FROM CLASS, TEACHES, PROFESSOR WHERE CLASS.Mode='$class_instruction_type'
                AND ClassCode LIKE '%$class_code%'
                AND CLASS.ClassNumber = TEACHES.ClassNumber
                AND PROFESSOR.PID = TEACHES.PID";
    }
    $result = $mysqli->query($query);
    
    echo '<br>';
    echo "<table border='1'>";
    echo "<tr><th>Class Code</th><th>Professor</th><th>Instruction Mode</th><th>Building Name</th><th>Building Number</th><th>Credit Hours</th><th>Seats Available</th><th>Time</th></tr>";
    while($row = mysqli_fetch_array($result)){
      echo "<tr><td>" . $row['ClassCode'] ."</td><td>". $row['name'] . "</td><td>" . $row['Mode']. "</td><td>" . $row['BuildingName'] . "</td><td>" . $row['RoomNumber'] . "</td><td>" . $row['CreditHours'] . "</td><td>" . $row['SeatsAvailable'] . "</td><td>" . $row['Time'] . "</td></tr>";
     }
    echo "</table>";
    $mysqli->close();

    ?>
