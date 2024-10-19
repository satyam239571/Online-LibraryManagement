<?php

$server   = "localhost";
$user = "root";
$pass = "";
$db = "lms";
$num = "1";

$sqlconn = new mysqli($server, $user, $pass, $db);

if ($sqlconn->connect_error) {
    echo "error";
    die($sqlconn->connect_error);
}
$sql = "SELECT * FROM books;";

$data = $sqlconn->query($sql);

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Library Management System</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <section id="header">
        <div class="container-fluid">
            <nav class="navbar navbar-expand-lg navbar-dark">
                <div class="container">
                    <a class="navbar-brand">Admin Dashboard</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a href="dashadmin.php" class="nav-link">Students</a>
                            </li>

                            <li class="nav-item active">
                                <a href="#" class="nav-link">Books</a>
                            </li>

                            <li class="nav-item">
                                <a href="" class="nav-link">Fine</a>
                            </li>

                            <li class="nav-item">
                                <a href="admin.html" class="nav-link">Logout</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
        <div class="container">
            <a href="addbook.html"><button type="button" class="btn btn-warning">Add Book</button></a>
            &nbsp;&nbsp;&nbsp;<a href="dashbook.php"><button type="button" class="btn btn-success">Refresh</button></a>
        </div>
    </section>

    <section class="main">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Slno.</th>
                                <th scope="col">Book Name</th>
                                <th scope="col">Author</th>
                                <th scope="col">Category</th>
                                <th scope="col">Publication</th>
                                <th scope="col">Edition</th>
                                <th scope="col">Price</th>
                                <th scope="col">Action</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <?php
                        if ($data->num_rows > 0) {
                            while ($row = $data->fetch_assoc()) {

                        ?>
                                <tbody>
                                    <tr>
                                        <th scope="row"><?php echo $num++; ?></th>
                                        <td><?php echo $row["bookname"]; ?></td>
                                        <td><?php echo $row["author"]; ?></td>
                                        <td><?php echo $row["category"]; ?></td>
                                        <td><?php echo $row["publication"]; ?></td>
                                        <td><?php echo $row["edition"]; ?></td>
                                        <td>Rs. <?php echo $row["price"]; ?></td>
                                        <td><a href="updatebook.php?book=<?php echo $row["bookname"]; ?>"> <button type="button" class="btn btn-warning">Update</button></a></td>
                                        <td><a href="delbook.php?book=<?php echo $row["bookname"]; ?>"> <button type="button" class="btn btn-danger">Delete</button></a></td>
                                    </tr>
                            <?php
                            }
                        } else {
                            echo "error: " . $sqlconn->error;
                        }

                        $sqlconn->close();
                            ?>
                                </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.js"></script>
</body>

</html>