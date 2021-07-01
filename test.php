
<?php 
include_once("database.php");
$allExceptCurrUser = mysqli_query($conn, "SELECT * FROM Users");
$data = mysqli_fetch_assoc($allExceptCurrUser);
print_r($data);
// $rows = mysqli_num_rows($allExceptCurrUser);

?>