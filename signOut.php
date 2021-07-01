<?php 

session_start();
session_unset();
session_destroy();
include_once("design.php");

// session_start(); 

?>

<div class="mt-5" style="text-align:center">
    <h1> You have successfully logged out of your account.</h1>
    <h3> Click <a href="/miniProject/signIn.php">here</a> to login again. </h3>
</div>

<?php 

// header("location: signOutMessage.php");
?>