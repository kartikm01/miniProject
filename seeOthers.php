<?php 
session_start();
include_once("design.php");
include_once("database.php");

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] != true) {
    // User is not logged in.
    header("location: /miniProject/signOut.php");
    exit;
}


$currSession = $_SESSION["username"];
$allExceptCurrUser = mysqli_query($conn, "SELECT * FROM Users WHERE Username <> '$currSession'");
$rows = mysqli_num_rows($allExceptCurrUser);


for($i = 0; $i < $rows; $i++) { 
    $data = mysqli_fetch_assoc($allExceptCurrUser);  ?>
    <div class="container-fluid mt-5 mb-5">
        <div class="card text-white bg-dark mb-3" style="width: 50rem;">
        <div class="card-body">
            <h5 class="card-title"><?php echo $data["Name"]; ?></h5><hr>
            <h6 class="card-subtitle mb-2"><?php echo $data["Age"] . " years old"; ?></h6>
            <p class="card-text">Hello! I am <?php echo $data["Name"] . ".";?></p>
            <!-- <a href="/miniProject/" class="card-link">Click here to know more.</a> -->
            <!-- <a href="#" class="card-link">Another link</a> -->
        </div>
        </div>
    </div>
<?php } ?>




