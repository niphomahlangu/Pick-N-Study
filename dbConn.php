<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "pns_db";

// Create connection
$conn = mysqli_connect($servername, $username, $password);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

//select database
$selectDB = mysqli_select_db($conn,$database);

if (!$selectDB) {
	$sql = "CREATE DATABASE ".$database;
	mysqli_query($conn, $sql);
}else{
  //database already exists
}

//connect to database
$conn = mysqli_connect($servername, $username, $password ,$database);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

//preload database
include 'preload.php';

?>