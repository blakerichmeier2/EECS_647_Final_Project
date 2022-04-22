<?php
    $class_code = $_POST["class_code"];
    $class_type = $_POST["class_type"];
    $class_term = $_POST["class_term"];
    $class_instruction_type = $_POST["class_instruction_type"];
  /*Tables are : CLASS, PROFESSOR, TEACHES, BUILDING, ROOM, HASROOM*/
  
    echo "class code: " . $class_code . "<br>";
    echo "class type: " . $class_type . "<br>";
    echo "class code: " . $class_term . "<br>";
    echo "class type: " . $class_instruction_type . "<br>";

    $mysqli = new mysqli("mysql.eecs.ku.edu", "p162g473", "ahH3hohi", "p162g473");

    if($mysqli->connect_error){
      die("Connection failed: " . $mysqli->connect_error);
    }
    /* the dummy table is a dummy table used to get simple queries setup*/
    if($class_code == "" && $class_instruction_type == "Any Instruction Mode"){
      $query = "SELECT * FROM dummy WHERE ClassTerm='$class_term'
                AND ClassType='$class_type'";
    }
    else if($class_code != "" && $class_instruction_type == "Any Instruction Mode"){
      $query = "SELECT * FROM dummy WHERE ClassCode='$class_code'
                AND ClassTerm='$class_term'
                AND ClassType='$class_type'";
    }
    else if($class_code == "" && $class_instruction_type != "Any Instruction Mode"){
      $query = "SELECT * FROM dummy WHERE ClassIntructionType='$class_instruction_type'
                AND ClassTerm='$class_term'
                AND ClassType='$class_type'";
    }
    else{
      $query = "SELECT * FROM dummy WHERE ClassIntructionType='$class_instruction_type'
                AND ClassTerm='$class_term'
                AND ClassCode='$class_code'
                AND ClassIntructionType='$class_instruction_type'";
    }
    $result = $mysqli->query($query);

    echo '<h2> Classes: </h2>';
    echo "<table border='1'>";
    echo "<tr><th>ClassCode</th><th>ClassType</th><th>ClassTerm</th><th>ClassInstructionType</th></tr>";
    while($row = mysqli_fetch_array($result)){
      /*will need to change the array indexes to the attributes of the actual tables*/
      echo "<tr><td>" . $row['ClassCode'] . "</td><td>" . $row['ClassType'] . "</td><td>" . $row['ClassTerm'] . "</td><td>" . $row['ClassIntructionType'] . "</td></tr>";
    }

    echo "</table>";
    $mysqli->close();

    ?>
