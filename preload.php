<?php

//create admin table
$sql = "CREATE TABLE `admins` (
    `AdminId` int NOT NULL AUTO_INCREMENT,
    `FirstName` varchar(50) NOT NULL,
    `LastName` varchar(50) NOT NULL,
    `Email` varchar(50) NOT NULL,
    `Password` varchar(50) NOT NULL,
    PRIMARY KEY (`AdminId`)
  ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci";

$create_tblAdmin = mysqli_query($conn,$sql);

//create book table
$sql = "CREATE TABLE `books` (
    `BookId` int NOT NULL AUTO_INCREMENT,
    `BookName` varchar(100) NOT NULL,
    `Category` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
    `Image` varchar(100) NOT NULL,
    `Price` int NOT NULL,
    PRIMARY KEY (`BookId`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci";

$create_tblBooks = mysqli_query($conn,$sql);

//create orders table
$sql = "CREATE TABLE `orders` (
    `OrderId` int NOT NULL AUTO_INCREMENT,
    `StudentNum` varchar(100) NOT NULL,
    `Qty` int NOT NULL,
    PRIMARY KEY (`OrderId`),
    KEY `StudentNum` (`StudentNum`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci";

$create_tblOrders = mysqli_query($conn,$sql);

//create orders_books table
$sql = "CREATE TABLE `orders_books` (
    `Id` int NOT NULL AUTO_INCREMENT,
    `OrderId` int NOT NULL,
    `BookId` int NOT NULL,
    PRIMARY KEY (`Id`),
    KEY `OrderId` (`OrderId`),
    KEY `BookId` (`BookId`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci";

$create_tblOrders_Books = mysqli_query($conn,$sql);

//create unverified_users table
$sql = "CREATE TABLE `unverified_users` (
    `StudentNum` varchar(50) NOT NULL,
    `FirstName` varchar(50) NOT NULL,
    `LastName` varchar(50) NOT NULL,
    `Email` varchar(50) NOT NULL,
    `Password` varchar(100) NOT NULL,
    PRIMARY KEY (`StudentNum`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci";

$create_tblUnverified_Users = mysqli_query($conn,$sql);

//create users table
$sql = "CREATE TABLE `users` (
    `StudentNum` varchar(50) NOT NULL,
    `AdminId` int NOT NULL,
    `FirstName` varchar(50) NOT NULL,
    `LastName` varchar(50) NOT NULL,
    `Email` varchar(50) NOT NULL,
    `Password` varchar(100) NOT NULL,
    PRIMARY KEY (`StudentNum`),
    KEY `AdminId` (`AdminId`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci";

$create_tblUsers = mysqli_query($conn,$sql);

if($create_tblAdmin && $create_tblBooks && $create_tblOrders && $create_tblOrders_Books && $create_tblUnverified_Users && $create_tblUsers){

    //alter all tables
    alterTables();

    //preload admin table
    loadAdmin();

    //load unverified user
    loadUnverifiedUsers();

    //preload books table
    loadBooks();

}else{
    //tables already exist
}

function loadAdmin(){
  global $conn;
  $adminId = "111";
  $fname = "Nipho";
  $lname = "Admin";
  $email = "admin@admin.com";
  $password = md5("admin123");

  $sql = "INSERT INTO admins (AdminId, FirstName, LastName, Email, Password) VALUES('$adminId','$fname','$lname','$email','$password')";
  mysqli_query($conn,$sql);
}

function alterTables(){
  global $conn;

    $sql = "ALTER TABLE `orders_books` ADD CONSTRAINT `orders_books_ibfk_1` FOREIGN KEY (`BookId`) REFERENCES `books` (`BookId`)";
    mysqli_query($conn,$sql);

    $sql = "ALTER TABLE `orders` ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`StudentNum`) REFERENCES `users` (`StudentNum`)";
    mysqli_query($conn,$sql);

    $sql = "ALTER TABLE `orders_books` ADD CONSTRAINT `orders_books_ibfk_1` FOREIGN KEY (`OrderId`) REFERENCES `orders` (`OrderId`)";
    mysqli_query($conn,$sql);

    $sql = "ALTER TABLE `users` ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`AdminId`) REFERENCES `admins` (`AdminId`)";
    mysqli_query($conn,$sql);
}

function loadUnverifiedUsers(){
  global $conn;
    $usersfile = fopen("userData.txt","r");

    while(!feof($usersfile)){
        $content = fgets($usersfile);
        $carray = explode(",",$content);
        list($stnumber,$name,$surname,$email,$password) = $carray;
        $sql = "INSERT INTO unverified_users (StudentNum, FirstName, LastName, Email, Password) VALUES('$stnumber', '$name', '$surname', '$email','$password')";
        $conn->query($sql);
    }
    fclose($usersfile);
}

function loadBooks(){
  global $conn;
    $bookfile = fopen("bookData.txt","r");

    while(!feof($bookfile)){
        $content = fgets($bookfile);
        $carray = explode(",",$content);
        list($bookname,$category,$image,$price) = $carray;
        $sql = "INSERT INTO books (BookName, Category, Image, Price) VALUES('$bookname','$category','$image','$price')";
        $conn->query($sql);
    }
    fclose($bookfile);
}


?>