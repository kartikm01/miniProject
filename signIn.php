<?php

include_once("design.php");
include_once("database.php");

// echo "Welcome to SignIn Page.";
?>


<?php 

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $pass = $_POST["pass"];
    
    if(!empty($email) && !empty($pass)) {
        $result = mysqli_query($conn, "SELECT * FROM Users WHERE Users.Username='$email' AND Users.Password='$pass'");
        $count = mysqli_num_rows($result);
        if($count == 1) {
            // Valid credentials...
            session_start();
            $_SESSION["loggedin"] = true;
            $_SESSION["username"] = $email;
            $res = mysqli_query($conn, "SELECT Name FROM Users WHERE Username='$email'");
            $arr = mysqli_fetch_assoc($res);
            $_SESSION["name"] = $arr['Name'];
            header("location: /miniProject/home.php");
        } else {
            // Invalid credentials..
            echo '<div class="alert alert-danger" role="alert">
            Invalid Credentials. Please check the Username or Password and <a href="/miniProject/signIn.php">login</a> again.
            <hr>
            <p>If you are not registered, please sign up <a href="/miniProject/signUp.php">here</a>.</p>
            </div>';
        } 
    }
}



?>




<!-- Sign In Form -->
<div class="mt-3" style="text-align:center">
    <h1> Welcome to BlogDott </h1>
    <h3>Please login to your account </h3>
</div>
<div class="container">
    <form action="/miniProject/signIn.php" method="POST" class="mt-5">
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Username</label>
        <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" required>
        <div id="help" class="form-text">Username is your emailID with which you have registered on BlogDott.</div>
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Password</label>
        <input type="password" class="form-control" name="pass" id="pass" required>
    </div>
    
    <div style="text-align:center">
    <button type="submit" class="btn btn-primary">Submit</button>
    </div>
    </form>
    <div class="mt-4" style="text-align:center">First time on BlogDott? <br><h5><a href="/miniProject/signUp.php">Sign Up</a></h5></div>
</div>

