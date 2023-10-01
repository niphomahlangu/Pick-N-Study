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
                        <a class="nav-link" href="#">Link</a>
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
    
    <div class="container" style="width: 65%">
        <h2>Pick N Study</h2>
        <?php
        $sql = "SELECT * FROM books";
        $result = mysqli_query($conn,$sql);

        while($row = mysqli_fetch_assoc($result)){
        ?>
        <div class="col-md-3">
            <form action="index.php?action=add&id=<?php echo $row["BookId"]; ?>" method="post">
                <div class="product">
                    <img src="<?php echo $row["Image"]; ?>" alt="" class="img-responsive">
                    <h5 class="text-info"><?php echo $row["BookName"]; ?></h5>
                    <h5 class="text-danger"><?php echo $row["Price"]; ?></h5>
                    <!-- <input type="text" name="quantity" id="" class="qty-input"> -->
                    <input type="submit" value="Add to Cart" class="btn btn-success">
                </div>
            </form>
        </div>
        <?php
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>