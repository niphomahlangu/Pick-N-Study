<?php

session_start();
include 'dbConn.php';

if(!$_SESSION['email']){
    header('location: adminLogin.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin @PNS | User Manager</title>

    <link rel="stylesheet" href="style.css">
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
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="admin.php">User Manager</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="book-manager.php">Book Manager</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
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
        <form action="book-manager.php" method="post">
            <input type="text" name="bookname" id="" class="form-control mx-auto" placeholder="Enter book name"><br>
            <input type="text" name="course" id="" class="form-control mx-auto" placeholder="Enter category"><br>
            <input type="text" name="price" id="" class="form-control mx-auto" placeholder="Enter book price"><br>
            <input type="submit" name="btn-add-book" value="Add Book" class="btn-submit"><br>
        </form>
    </div>

    <div class="table-container">
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
            <?php }?>
        </table>
    </div>

    <footer class="footer">
        Created by Ntokozo Mahlangu
    </footer>
</body>
</html>