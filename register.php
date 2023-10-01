<?php
session_start();
include 'dbConn.php';

//variable declarations
$output = null;

if(isset($_POST['btn_register'])){

    //get input
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $studentnum = $_POST['studentnum'];
    $email = $_POST['email'];
    $newPass = $_POST['newPass'];
    $confirmPass = $_POST['confirmPass'];
    //encrypt password
    $hpass = md5($newPass);

    //check empty fields
    if($fname == null || $lname == null || $email == null || $studentnum == null || $newPass == null || $confirmPass == null){
        $output = "<div class='alert alert-danger'>Empty fields not required.</div>";
    }

    //validate matching passwords
    elseif($newPass!=$confirmPass){
        $output = "<div class='alert alert-danger'>Passwords do not match.</div>";
    }
    else{
        
        //check existing user
        $sql = "SELECT Email FROM users WHERE Email = '$email'";
        $result = mysqli_query($conn, $sql);

        if(mysqli_fetch_assoc($result)){
            $output = "<div class='alert alert-danger'>This email address OR student number might already exists.</div>";
        }else{
            
                
            //enter user input into database
            $sql = "INSERT INTO unverified_users (FirstName, LastName, StudentNum, Email, Password) VALUES('$fname', '$lname', '$studentnum', '$email', '$hpass')";
            $result = mysqli_query($conn, $sql);
            if($result){
                $output = "<div class='alert alert-success'>Thank you. The account will be verified by the administrator.</div>";
            }else{
                "<div class='alert alert-danger'>Failed to register account. The student number might already exist.</div>";
            }
        }
    }
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Account | Pick N Study</title>

    <link rel="stylesheet" href="register_style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
<body>
    <header>
    <img src="images/logo/logo" alt="" width="150" height="50">
    </header>
    
    <div class="container w-75 p-3">
        <h1 class="text-primary">Sign Up</h1><br>
        <?php echo $output; ?>
        <form action="register.php" method="post">
            <input type="text" class="form-control mx-auto" name="fname" id="" placeholder="Enter First Name"><br>
            <input type="text" class="form-control mx-auto" name="lname" id="" placeholder="Enter Last Name"><br>
            <input type="email" class="form-control mx-auto" name="email" id="" placeholder="Enter Email Address" ><br>
            <input type="text" class="form-control mx-auto" name="studentnum" id="" placeholder="Enter Student Number" ><br>
            <input type="password" class="form-control mx-auto" name="newPass" id="" placeholder="Enter New Password"><br>
            <input type="password" class="form-control mx-auto" name="confirmPass" id="" placeholder="Confirm Password"><br>
            <input type="submit" class="form-control mx-auto" name="btn_register" value="REGISTER" >
        </form>
        <br>
        Already have an account? <a href="login.php" class="log_link">Login here</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>