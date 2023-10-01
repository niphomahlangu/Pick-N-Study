<?php
session_start();
include 'dbConn.php';

//variable declarations
$output = null;

//redirect to home page if user is signed in
if(isset($_SESSION["email"])){
    header('index.php');
}

if(isset($_POST['btn_login'])){
    
    //get user inputs
    $email = $_POST['email'];
    $password = $_POST['password'];

    //hash password
    $hpass = md5($password);

    if($email == null || $password == null){
        $output = "<div class='alert alert-danger'>Empty fields not required.</div>";
    }else{
        //check for existing user
        $sql = "SELECT * FROM users WHERE Email = '$email' AND Password = '$hpass'";
        $result = mysqli_query($conn, $sql);

        if(mysqli_fetch_assoc($result)){
            // Set session variables
            $_SESSION["email"] = $email;
            //navigate to home page
            header('location: index.php');
        }else{
            $output = "<div class='alert alert-danger'>Account not verified. Contact administrator.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Pick N Study</title>

    <link rel="stylesheet" href="login_style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
<body>
    <header>
        <img src="images/logo/logo" alt="" width="150" height="50">
    </header>
    <a href="adminLogin.php">Admin Only</a>
    <div class="shadow w-50 p-3">
        <h1 class="text-primary">Login</h1><br>
        <?php echo $output; ?>
            <form action="login.php" method="post">
                <input type="email" class="form-control mx-auto" name="email" id="" placeholder="Email address" ><br>
                <input type="password" class="form-control mx-auto" name="password" id="" placeholder="Password"><br>
                <input type="submit" class="form-control mx-auto" name="btn_login" value="LOGIN" >
            </form>
            <br>
            Don't have an account? <a href="register.php" class="reg_link">Register here</a>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>                                                                     