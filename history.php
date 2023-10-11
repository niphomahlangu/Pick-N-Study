<?php
session_start();
include 'dbConn.php';

if(!$_SESSION['email']){
    header('location: login.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping History | PNS</title>

    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
<body>
    <header>
            <nav class="navbar navbar-expand-lg border-bottom">
                <div class="container-fluid">
                    <a class="navbar-brand" href="index.php">
                        <img src="images/logo/logo" alt="" width="150" height="50">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="index.php">Home</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" href="history.php">Shopping History</a>
                            </li>
                            <li class="nav-item">
                                <form method="post" action="index.php" >
                                    <input type="submit" class="btn btn-primary rounded-pill" name="btn_logout" value="LOGOUT">
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
    </header>

    <div class="container">
        <h1>Order History</h1>
        <div class="table-container">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <th>Date</th>
                        <th>Order Id</th>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total Price</th>
                    </thead>
                    <?php
                    //join and read data from existing tables
                    $sql = "SELECT Date, orders_books.OrderId, books.BookName, books.Price, Qty FROM orders_books
                    INNER JOIN orders ON orders_books.OrderId = orders.OrderId
                    INNER JOIN books ON orders_books.BookId = books.BookId
                    ORDER BY Date DESC, orders_books.OrderId DESC";

                    $result = mysqli_query($conn, $sql);
                    while($row = mysqli_fetch_assoc($result)){
                    ?>
                    <tbody>
                        <td><?php echo $row["Date"];?></td>
                        <td><?php echo $row["OrderId"];?></td>
                        <td><?php echo $row["BookName"];?></td>
                        <td><?php echo $row["Qty"];?></td>
                        <td>R <?php echo $row["Price"];?></td>
                        <td>R <?php echo number_format($row["Qty"] * $row["Price"], 2);?></td>
                    </tbody>
                    <?php
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>

    <footer class="footer">
        Created by Ntokozo Mahlangu
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>