<?php
session_start();
include 'dbConn.php';

//user places order
if(isset($_POST["btn-order"])){
    //today's date
    $currentDate = date('Y-m-d');

    //get email address
    $email = $_SESSION['email'];

    //get student number
    $sql = "SELECT * FROM users WHERE Email='$email'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $stnumber = $row["StudentNum"];

    //insert into orders
    $sql = "INSERT INTO orders (StudentNum, Date) VALUES('$stnumber','$currentDate')";
    mysqli_query($conn, $sql);

    //get order Id
    $sql = "SELECT * FROM orders ORDER BY OrderId DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $orderId = $row["OrderId"];

    foreach($_SESSION["cart"] as $key => $value){
        $quantity = $value["quantity"];
        $bookId = $value["item_id"];

        //insert into orders_books
        $sql = "INSERT INTO orders_books (OrderId, BookId, Qty) VALUES('$orderId','$bookId','$quantity')";
        $result = mysqli_query($conn, $sql);

        if($result){
            echo '<script>alert("Order placed successfully. Thank you for shopping with us.")</script>';
            echo '<script>window.location="checkout.php"</script>';
            unset($_SESSION["cart"]);
        }
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PNS | Checkout Zone</title>

    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
<body>
<header>
        <nav class="navbar navbar-expand-lg border-bottom">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
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
                        <a class="nav-link" href="">Cart</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="history.php">Shopping History</a>
                        </li>
                        <li class="nav-item">
                            <form method="post" action="index.php" >
                                <input type="submit" name="btn_logout" value="LOGOUT">
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="container">
        <h1 class="h1 text-danger">Check Out Zone</h1>

        <div class="table-container">
            <h2>Order Information</h2>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th width="30%">Item Name</th>
                            <th width="10%">Quantity</th>
                            <th width="10%">Price</th>
                            <th width="15%">Subtotal Price</th>
                            <th width="15%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if(!empty($_SESSION["cart"])){
                            $total = 0;
                            foreach($_SESSION["cart"] as $key => $value){
                        ?>
                        <tr>
                            <td><?php echo $value["item_name"]; ?></td>
                            <td><?php echo $value["quantity"]; ?></td>
                            <td>R <?php echo $value["price"]; ?></td>
                            <td>R <?php echo number_format($value["quantity"] * $value["price"], 2); ?></td>
                            <td><a href="checkout.php?action=delete&id=<?php echo $value["item_id"]; ?>">Remove Item</a></td>
                        </tr>
                        <?php
                        $total = $total + ($value["quantity"] * $value["price"]);
                            }
                        ?>
                        <tr>
                            <th colspan="3">Total</th>
                            <th>R <?php echo number_format($total, 2); ?></th>
                            <th></th>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            
            <form action="checkout.php" method="post">
                <input type="submit" name="btn-order" value="Place Order">
            </form>
        </div>
    </div>
    

    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

    <!-- <footer class="footer">
        Created by Ntokozo Mahlangu
    </footer> -->
</body>
</html>