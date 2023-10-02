<?php
session_start();
include 'dbConn.php';

if(!$_SESSION['email']){
    header('location: adminLogin.php');
}

if(isset($_POST['btn_logout'])){
    session_destroy();
    header('location: adminLogin.php');
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
    
    <div class="table-container">
        <h1>Unverified Users</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Surname</th>
                    <th>Email</th>
                    <th>Action</th>
                    <th></th>
                </tr>
            </thead>
            
            <?php 
            $sql = "SELECT * FROM unverified_users";
            $result = mysqli_query($conn, $sql);

            while($row = mysqli_fetch_assoc($result)){ ?>
            <tbody>
                <tr>
                    <td><?php echo $row["FirstName"]; ?></td>
                    <td><?php echo $row["LastName"]; ?></td>
                    <td><?php echo $row["Email"]; ?></td>
                    <td><a href="process.php?verify=<?php echo $row['StudentNum']; ?>" class="btn-edit">Verify</a></td>
                    <td><a href="process.php?remove=<?php echo $row['StudentNum']; ?>" class="btn-delete">Remove</a></td>
                </tr>
            </tbody>
                
            <?php } ?>
        </table>
    </div>

    <div class="table-container-2">
        <h1>Verified Users</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Student Number</th>
                    <th>Admin Id</th>
                    <th>Name</th>
                    <th>Surname</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <?php 
            $sql = "SELECT * FROM users";
            $result = mysqli_query($conn, $sql);

            while($row = mysqli_fetch_assoc($result)){ ?>
            <tbody>
                <tr>
                    <td><?php echo $row["StudentNum"]; ?></td>
                    <td><?php echo $row["AdminId"]; ?></td>
                    <td><?php echo $row["FirstName"]; ?></td>
                    <td><?php echo $row["LastName"]; ?></td>
                    <td><?php echo $row["Email"]; ?></td>
                    <td><a href="process.php?del=<?php echo $row["StudentNum"]; ?>" class="btn-delete">Remove</a></td>
                </tr>
            </tbody>
            <?php } ?>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <footer class="footer">
        Created by Ntokozo Mahlangu
    </footer>
</body>
</html>