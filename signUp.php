<?php
include_once("design.php");
// echo "Welcome To SignUp Page."
?>

<!-- Required meta tags -->
    <!-- <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"> -->

    <!-- Bootstrap CSS -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->

<?php
 if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(!empty($_POST["name"]) && !empty($_POST["email"]) && 
       !empty($_POST["pass"]) && !empty($_POST["age"])) {
        // back end Email and password validation...
        // $regExEmail = "/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/";
        $regExEmail = "/^[a-zA-Z0-9+_.-]+@[a-zA-Z0-9.-]+$/";
        $regExPass = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,15}$/";
        if (preg_match($regExEmail, $_POST["email"]) == 0) {
            echo '<div class="alert alert-danger" role="alert"><strong>Error!</strong> Please enter a valid email.</div>';
        } else if(preg_match($regExPass, $_POST["pass"]) == 0) {
            echo '<div class="alert alert-danger" role="alert"><strong>Error!</strong> Please enter a valid password using the constraints given.</div>';
        } else if($_POST["age"] < 10) {
            echo '<div class="alert alert-danger" role="alert"><strong>Error!</strong> You should be atleast 10 years years old to join BlogDott.</div>';
        } else { 

        $name = $_POST["name"];
        $email = $_POST["email"];
        $pass = $_POST["pass"];
        $age = $_POST["age"];

        $servername = "localhost";
        $username = "root";
        $password = "";
        $myDB = "miniProject";

        $conn = mysqli_connect($servername, $username, $password, $myDB);
        if(!$conn) {
            die("Sorry! We are not able to connect to our database. " . mysqli_connect_error());
        } else { 
            $result = mysqli_query($conn, "SELECT * FROM Users WHERE Username='$email'");
            $count = mysqli_num_rows($result);
            if($count > 0) { 
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
            } else {
                // Username is unique. Registration successful.
                $insertQuery = mysqli_query($conn, "INSERT INTO `Users` (`Username`, `Name`, `Password`, `Age`) VALUES ('$email', '$name', '$pass', '$age');");
                
                echo '<div class="alert alert-success" role="alert">
                <h4 class="alert-heading">Welcome, <?php echo $name ?>!</h4>
                <p>You have successfully created an account on BlogDott.</p>
                <hr>
                Please click <a class="mb-0" href="/miniProject/signIn.php">here</a> to login to your account.
                </div>';
            } } }   } } ?>

                


<!-- Sign Up Form -->
<div class="mt-3" style="text-align:center">
    <h1> We are looking forward to seeing you on BlogDott. </h1>
    <h3> Please enter the following details: </h3>
</div>
<div class="container">
    <form action="/miniProject/signUp.php" method="POST" class="mt-5">

    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Username</label>
        <input placeholder="test@example.com" type="text" class="form-control" name="email" id="email" onchange="emailValidation()" aria-describedby="emailHelp" required>
        <div id="help" class="form-text">Username should be your emailID. We'll never share your email with anyone else.</div>
    </div>

    <div class="mb-3">
        <label for="name1" class="form-label">Name</label>
        <input type="text" class="form-control" name="name" id="name" required>
    </div>
         
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Password</label>
        <input type="password" class="form-control" name="pass" id="pass" onchange="passValidation()" required>
        <div id="help" class="form-text">Password must be 8-15 characters long and must contain atleast one uppercase letter, one lowercase letter, one number and one special character.</div>
    </div>
    <div class="mb-3">
        <label for="age1" class="form-label">Age</label>
        <input type="number" class="form-control" name="age" id="age" onchange="ageValidation()" required>
        <div id="help" class="form-text">Minimum age to join BlogDott is 10.</div>
    </div>
    
    <div class="mt-4" style="text-align:center">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
    </form>
    <div class="mt-3" style="text-align:center"><small> Already registered? <a href="/miniProject/signIn.php">Click here to login.</a></small></div></div> 

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
    