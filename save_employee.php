<?php
include('config.php');
$current=date('d-M-y');

if(isset($_POST['Fname'])){
  $Fname=$_POST['Fname'];
  $Lname=$_POST['Lname'];
  $Email=$_POST['Email'];
  $Phone=$_POST['Phone'];
  $JobTitle=$_POST['JobTitle'];
  $DuplicateE = "SELECT EmployeeID FROM employees WHERE EmployeeEmail = ?";
  $DuplicateF = "SELECT EmployeeID FROM employees WHERE EmployeeFN = ?";
  
  $stmtE = $conn->prepare($DuplicateE);
  $stmtE->bind_param("s", $Email);
  $stmtE->execute();
  $stmtE->store_result();
  
  $stmtF = $conn->prepare($DuplicateF);
  $stmtF->bind_param("s", $Fname);
  $stmtF->execute();
  $stmtF->store_result();
  
  $hasDuplicate = false;
  if ($stmtE->num_rows > 0) {
      $hasDuplicate = true;
      echo "There is already a record with the same email address in the database.";
      echo $conn->error;
  }
  
  if ($stmtF->num_rows > 0) {
      $hasDuplicate = true;
      echo "There is already a record with the same first name in the database.";
      echo $conn->error;
  }
  
  if (!$hasDuplicate) {
      $sql = "INSERT INTO employees SET EmployeeFN='$Fname', EmployeeLN='$Lname', EmployeeEmail='$Email', EmployeePhone='$Phone', HireDate='$current', ManagerID=50, JobTitle='$JobTitle'";
  
      if ($conn->query($sql)) {
          header("location:EmployeeList.php"); // redirect in php
      } else {
          echo $conn->error;
      }
  }
  $stmtE->close();
  $stmtF->close();
}

?>
