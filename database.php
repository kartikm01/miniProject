<?php 

$servername = "localhost";
$username = "root";
$password = "";
$myDB = "miniProject";

$conn = mysqli_connect($servername, $username, $password, $myDB);

// if(!$conn) {
//     die("Sorry! Connection not achieved. " . mysqli_connect_error());
// } else {
//     echo "Connection was successful.<br>";
// }

// $createDatabaseQuery = mysqli_query($conn, "CREATE TABLE `miniProject`.`Users` ( `UserID` INT NOT NULL AUTO_INCREMENT , `Username` VARCHAR(10) NOT NULL , `Password` VARCHAR(15) NOT NULL , `Age` INT NOT NULL , PRIMARY KEY (`UserID`)) ENGINE = InnoDB;
// ");

// if($createDatabaseQuery) {
//     echo "database created.<br>";
// } else {
//     echo "databse not created.<br>" . mysqli_error($conn);
// }



?>