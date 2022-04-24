<?php
    $class_code = $_POST["class_code"];
    $class_type = $_POST["class_type"];
    $class_term = $_POST["class_term"];
    $class_instruction_type = $_POST["class_instruction_type"];
  
    echo "class code: " . $class_code . "<br>";
    echo "class type: " . $class_type . "<br>";
    echo "class code: " . $class_term . "<br>";
    echo "class type: " . $class_instruction_type . "<br>";

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
    echo '<h2> Classes: </h2>';
    echo "<table border='1'>";
    echo "<tr><th>ClassCode</th><th>Professor</th><th>Room Number</th><th>Building Number</th><th>Credit Hours</th><th>Seats Availiable</th><th>Time</th></tr>";
    while($row = mysqli_fetch_array($result)){
      echo "<tr><td>" . $row['ClassCode'] ."</td><td>". $row['name'] . "</td><td>" . $row['Mode']. "</td><td>" . $row['BuildingName'] . "</td><td>" . $row['RoomNumber'] . "</td><td>" . $row['CreditHours'] . "</td><td>" . $row['SeatsAvailable'] . "</td><td>" . $row['Time'] . "</td></tr>";
     }
    echo "</table>";
    $mysqli->close();

    ?>
