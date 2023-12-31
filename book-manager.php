<?php

session_start();
include 'dbConn.php';

//variable declarations
$output = $id = $bookname = $category = $price = null;
$update = false;

if(!$_SESSION['email']){
    header('location: adminLogin.php');
}

if(isset($_POST["btn-add"])){
    //get user input
    $bookname = $_POST["bookname"];
    $category = $_POST["category"];
    $image = "images//books//coming-soon.png";
    $price = $_POST["price"];

    //validate user input
    if($bookname == null || $category == null || $price == null){
        $output = "<div class='alert alert-danger'>Empty fields not required.</div>";
    }else{
        //add data to database
        $sql = "INSERT INTO books (BookName, Category, Image, Price) VALUES('$bookname','$category','$image','$price')";
        $result = mysqli_query($conn,$sql);
        if($result){
            echo '<script>alert("Book added successfully.")</script>';
            echo '<script>window.location="book-manager.php"</script>';
        }
    }
}

if(isset($_GET["edit"])){
    $update = true;
    //get book id
    $id = $_GET["edit"];
    //get selected book
    $sql = "SELECT * FROM books WHERE BookId='$id'";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_assoc($result);

    $bookname = $row["BookName"];
    $category = $row["Category"];
    $price = $row["Price"];
}

if(isset($_GET["del"])){
    //get book id
    $id = $_GET["del"];

    //get selected book
    $sql = "DELETE FROM books WHERE BookId='$id'";
    $result = mysqli_query($conn,$sql);
    if($result){
        echo '<script>alert("Item deleted.")</script>';
        echo '<script>window.location="book-manager.php"</script>';
    }else{
        echo '<script>alert("FAILED to delete Item.")</script>';
        echo '<script>window.location="book-manager.php"</script>';
    }
}

if(isset($_POST["btn-update"])){
    //get user input
    $id = $_POST["id"];
    $bookname = $_POST["bookname"];
    $category = $_POST["category"];
    $price = $_POST["price"];
    
    //update book information
    $sql = "UPDATE books SET BookName='$bookname', Category='$category', Price='$price' WHERE BookId='$id'";
    $result = mysqli_query($conn,$sql);
    if($result){
        echo '<script>alert("Book updated successfully.")</script>';
        echo '<script>window.location="book-manager.php"</script>';
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin @PNS | User Manager</title>

    <link rel="stylesheet" href="admin-style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg border-bottom">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                <img src="images/logo/logo.png" alt="" width="150" height="50">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="admin.php">User Manager</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="book-manager.php">Book Manager</a>
                        </li>
                        <li class="nav-item">
                            <form action="admin.php" method="post">
                                <input type="submit" name="btn_logout" value="LOGOUT">
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="prompt-box">
        <h1>Enter Book Info</h1><br>
        <?php echo $output; ?>
        <form action="book-manager.php" method="post">
            <?php if ($update == true): ?>
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="text" name="bookname" id="" class="form-control mx-auto" placeholder="Enter book name" value="<?php echo $bookname; ?>"><br>
                <input type="text" name="category" id="" class="form-control mx-auto" placeholder="Enter category" value="<?php echo $category; ?>"><br>
                <input type="text" name="price" id="" class="form-control mx-auto" placeholder="Enter book price" value="<?php echo $price; ?>"><br>
                <input type="submit" name="btn-update" value="Update Book" class="btn-submit"><br>
            <?php else: ?>
                <input type="text" name="bookname" id="" class="form-control mx-auto" placeholder="Enter book name"><br>
                <input type="text" name="category" id="" class="form-control mx-auto" placeholder="Enter category"><br>
                <input type="text" name="price" id="" class="form-control mx-auto" placeholder="Enter book price"><br>
                <input type="submit" name="btn-add" value="Add Book" class="btn-submit"><br>
            <?php endif ?>
        </form>
    </div>

    <div class="table-container">
        <h2>Book Inventory</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Book Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Action</th>
                    <th></th>
                </tr>
            </thead>
            <?php
            $sql = "SELECT * FROM books";
            $result = mysqli_query($conn,$sql);

            while($row = mysqli_fetch_assoc($result)){
            ?>
            <tbody>
                <tr>
                    <td><?php echo $row["BookName"]; ?></td>
                    <td><?php echo $row["Category"]; ?></td>
                    <td><?php echo $row["Price"]; ?></td>
                    <td><a href="book-manager.php?edit=<?php echo $row["BookId"]; ?>" class="btn-edit">Edit</a></td>
                    <td><a href="book-manager.php?del=<?php echo $row["BookId"]; ?>" class="btn-delete">Delete</a></td>
                </tr>
            </tbody>
            <?php 
            }
            ?>
        </table>
    </div>

    <footer class="footer">
        Created by Ntokozo Mahlangu
    </footer>
</body>
</html>