<?php
session_start();
include 'dbConn.php';

if(!$_SESSION['email']){
    header('location: login.php');
}

if(isset($_POST['btn_logout'])){
    session_destroy();
    header('location: login.php');
}

//when user adds items to cart
if(isset($_POST["add"])){
    if (isset($_SESSION["cart"])){
        //get item id in session variable
        $item_array_id = array_column($_SESSION["cart"],"item_id");

        //if item id is not in the session variable
        if(!in_array($_GET["id"],$item_array_id)){
            //get item index
            $count = count($_SESSION["cart"]);

            //add item info into item array
            $item_array = array(
                'item_id' => $_GET["id"],
                'item_name' => $_POST["hidden_name"],
                'price' => $_POST["hidden_price"],
                'quantity' => $_POST["quantity"],
            );

            //assign item array to index
            $_SESSION["cart"][$count] = $item_array;
            echo '<script>alert("Item successfully added to cart.")</script>';
            echo '<script>window.location="index.php"</script>';
        }else{
            echo '<script>alert("Item already exists in the Cart")</script>';
            echo '<script>window.location="index.php"</script>';
        }
    }else{
        $item_array = array(
            'item_id' => $_GET["id"],
            'item_name' => $_POST["hidden_name"],
            'price' => $_POST["hidden_price"],
            'quantity' => $_POST["quantity"],
        );
        $_SESSION["cart"][0] = $item_array;
    }
}

if(isset($_GET["action"])){
    if ($_GET["action"] == "delete"){
        foreach ($_SESSION["cart"] as $keys => $value){
            if ($value["item_id"] == $_GET["id"]){
                unset($_SESSION["cart"][$keys]);
                echo '<script>alert("Item has been Removed.")</script>';
                echo '<script>window.location="index.php"</script>';
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
    <title>Pick N Study</title>

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
                        <a class="nav-link" aria-current="page" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="#">Cart</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="#">Shopping History</a>
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
        <h1 class="h1 text-danger">Welcome to Pick N Study</h1>
        <?php
        $sql = "SELECT * FROM books";
        $result = mysqli_query($conn,$sql);

        while($row = mysqli_fetch_assoc($result)){
        ?>
        <div class="col-md-4 mx-auto">
            <form action="index.php?action=add&id=<?php echo $row["BookId"]; ?>" method="post">
                <div class="product">
                    <img src="<?php echo $row["Image"]; ?>" alt="" class="img-responsive">
                    <h5 class="text-info"><?php echo $row["BookName"]; ?></h5>
                    <h5 class="text-danger">R <?php echo $row["Price"]; ?></h5>
                    <input type="text" name="quantity" id="" class="form-control mx-auto" required><br>
                    <input type="hidden" name="hidden_name" value="<?php echo $row["BookName"]; ?>">
                    <input type="hidden" name="hidden_price" value="<?php echo $row["Price"]; ?>">
                    <input type="submit" name="add" value="Add to Cart" class="btn btn-success">
                </div>
            </form>
        </div>
        <?php
        }
        ?>
    </div>

    <div class="container">
        <h2 class="h2 text-danger">Shopping Cart</h2>
        
        <div class="table-responsive">
            <table class="table table-bordered border-dark-subtle">
                <thead>
                    <tr>
                        <th width="30%">Item Name</th>
                        <th width="10%">Quantity</th>
                        <th width="10%">Price</th>
                        <th width="15%">Subtotal</th>
                        <th width="10%"></th>
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
                        <td><a href="index.php?action=delete&id=<?php echo $value["item_id"]; ?>">Remove Item</a></td>
                    </tr>
                    <?php
                    $total = $total + ($value["quantity"] * $value["price"]);
                        }
                    ?>
                    <tr>
                        <th colspan="3">Total</th>
                        <th>R <?php echo number_format($total, 2); ?></th>
                        <td><a href="checkout.php" class="btn-checkout">Check Out</a></td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

    <footer class="footer">
        Created by Ntokozo Mahlangu
    </footer>
</body>
</html>