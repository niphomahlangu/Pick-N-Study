<?php
session_start();
include 'dbConn.php';

//variables
$fname = $lname = $email = $adminId = null;

if(isset($_SESSION["adminId"])){
    $adminId = $_SESSION["adminId"];
}

if(isset($_GET['verify'])){
    $user_id = $_GET['verify'];

    $sql = "SELECT * FROM unverified_users WHERE StudentNum = '$user_id'";
    $result = mysqli_query($conn, $sql);

    if($row = mysqli_fetch_assoc($result)){
        $fname = $row['FirstName'];
        $lname = $row['LastName'];
        $email = $row['Email'];
        $password = $row['Password'];
        
        $sql = "INSERT INTO users (StudentNum, AdminId, FirstName, LastName, Email, Password) VALUES('$user_id','$adminId','$fname','$lname','$email','$password')";
        mysqli_query($conn, $sql);

        $sql = "DELETE FROM unverified_users WHERE StudentNum = '$user_id'";
        mysqli_query($conn, $sql);
        
        header('location: admin.php');
    }
}

if(isset($_GET['remove'])){
    $user_id = $_GET['remove'];
    $sql = "DELETE FROM unverified_users WHERE StudentNum = '$user_id'";
    mysqli_query($conn, $sql);
    header('location: admin.php');
}

if(isset($_GET['del'])){
    $user_id = $_GET['del'];
    $sql = "DELETE FROM users WHERE StudentNum = '$user_id'";
    mysqli_query($conn, $sql);
    header('location: admin.php');
}

?>