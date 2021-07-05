<?php 

session_start();
include_once("design.php");
include_once("database.php");

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] != true) {
    // User is not logged in.
    header("location: /miniProject/signOut.php");
    exit;
}

 
$currUsername = $_SESSION["username"];
$res = mysqli_query($conn, "SELECT * FROM Users WHERE Username='$currUsername'");
$arr = mysqli_fetch_assoc($res);
$currName = $arr["Name"];
$currAge = $arr["Age"];

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $newUsername = $_POST["email"];
    $newName = $_POST["name"];
    $newAge = $_POST["age"];

    // new email and age validation
    $regExEmail = "/^[a-zA-Z0-9+_.-]+@[a-zA-Z0-9.-]+$/";
    $regExPass = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,15}$/";
    if (preg_match($regExEmail, $newUsername) == 0) {
        echo '<div class="alert alert-danger" role="alert"><strong>Error!</strong> Please enter a valid email.</div>';
    } else if($newAge < 10) {
        echo '<div class="alert alert-danger" role="alert"><strong>Error!</strong> You should be atleast 10 years years old to join BlogDott.</div>';
    } else {
        // check for duplication of email in database.
        $result = mysqli_query($conn, "SELECT * FROM Users WHERE Username='$newUsername'");
        $count = mysqli_num_rows($result);
        if($count == 0 || $currUsername == $newUsername) { 
            // New Username is unique OR Username is unchanged. Update in database.
            $res = mysqli_query($conn, "UPDATE `Users` SET `Username` = '$newUsername', `Name` = '$newName', `Age` = '$newAge' WHERE `Users`.`Username` = '$currUsername'");
            $_SESSION["username"] = $newUsername;
            $_SESSION["name"] = $newName;
            echo '<div class="alert alert-success" role="alert">
                  <h4 class="alert-heading">SUCCESS!</h4>
                  <p>Your details have been updated successfully.</div>';
        } else {
            // Username is not unique.  
            echo '<div style="text-align:left">
                <div class="alert alert-danger  alert-dismissible fade show" role="alert">
                <strong>Sorry!</strong> The username you have entered already exists. 
                Username will be used to identify you on BlogDott. Please choose another username.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>
                </div>';
        }    
    }
}

?>
<title><?php echo $_SESSION["name"]; ?></title>

<h1 class="mt-5" style="text-align:center">You can edit the enteries below:</h1>

<div class="container">
    <form action="/miniProject/editProfile.php" method="POST" class="mt-5">

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Username</label>
        <input type="text" class="form-control" name="email" id="email" onchange="emailValidation()" value=<?php echo $_SESSION["username"]; ?> aria-describedby="emailHelp" required>
        <div id="help" class="form-text">Username should be your emailID. We'll never share your email with anyone else.</div>
    </div>

    <div class="mb-3">
        <label for="name1" class="form-label">Name</label>
        <input type="text" class="form-control" name="name" id="name" value=<?php echo $_SESSION["name"]; ?> required>
    </div>
         
    <!-- <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Password</label>
        <input type="password" class="form-control" name="pass" id="pass" onchange="passValidation()" required>
        <div id="help" class="form-text">Password must be 8-15 characters long and must contain atleast one uppercase letter, one lowercase letter, one number and one special character.</div>
    </div> -->
    <div class="mb-3">
        <label for="age1" class="form-label">Age</label>
        <input type="number" class="form-control" name="age" id="age" onchange="ageValidation()" value=<?php if(!isset($newAge)) { echo $currAge; } else { echo $newAge; } ?> required>
        <div id="help" class="form-text">Minimum age to join BlogDott is 10.</div>
    </div>
    <!-- <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="exampleCheck1">
        <label class="form-check-label" for="exampleCheck1">Check me out</label>
    </div> -->
    <div class="mt-4" style="text-align:center">
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
    <div class="mt-4" style="text-align:center"><h5><a href="#">Change Password</a></h5></div>
    </form>
</div>


<!-- Functions for real time validation -->
<script>
    function passValidation(){
        var pass = document.getElementById("pass").value;
        var regEx = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,15}$/;
        if (!regEx.test(pass)) {
            alert("Enter valid password!");
            document.getElementById("pass").value = "";
        }
    } 
    
    function emailValidation(){
        var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
        var email = document.getElementById("email").value;
        if (!validRegex.test(email)) {
            alert("Sorry Wrong Email");
            document.getElementById("email").value = "";
        }
    }

    function ageValidation(){
        if(document.getElementById("age").value < 10) {
            alert("Not Eligible");
            document.getElementById("age").value = "";
        }
    }
</script>
