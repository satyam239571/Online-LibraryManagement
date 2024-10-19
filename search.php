<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Custom CSS -->
    <style>
        body {
            background: url('img/search.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #ffffff;
            font-family: 'Roboto', sans-serif;
        }

        .container {
            background: rgba(255, 255, 255, 0.85);
            padding: 30px;
            border-radius: 10px;
            margin-top: 50px;
        }

        h3 {
            font-size: 2rem;
            color: #343a40;
        }

        form label {
            font-weight: bold;
        }

        .form-control {
            background: #f5f5f5;
            border-radius: 8px;
            border: 2px solid #ced4da;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.5);
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            border-radius: 50px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .list-group-item {
            background-color: #ffffff;
            color: #333;
            border: 1px solid #dee2e6;
            transition: background-color 0.3s;
        }

        .list-group-item:hover {
            background-color: #f8f9fa;
        }

        .btn-success, .btn-warning {
            border-radius: 30px;
            padding: 8px 20px;
            font-size: 1rem;
        }

        .alert-warning {
            background-color: #ffc107;
            color: #333;
        }
    </style>

    <title>Library Management System</title>
</head>

<body>

    <div class="container mt-4">
        <h3><?php echo "Welcome!"; ?><br> You can now use this website to search for books.</h3>
        <hr>

        <!-- Search Form -->
        <form method="POST" action="">
            <div class="form-row">
                <div class="form-group col-md-5">
                    <label for="book_name">Book Name:</label>
                    <input type="text" class="form-control" id="book_name" name="book_name" placeholder="Enter book name">
                </div>
                <div class="form-group col-md-5">
                    <label for="author_name">Author:</label>
                    <input type="text" class="form-control" id="author_name" name="author_name"
                        placeholder="Enter author name">
                </div>
                <div class="form-group col-md-2">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-primary btn-block" name="search">Search</button>
                </div>
            </div>
        </form>

        <!-- Search Results -->
        <div id="search-results">
            <?php
            if (isset($_POST['search'])) {
                $server = "localhost";
                $user = "root";
                $pass = "";
                $db = "lms";
                $conn = new mysqli($server, $user, $pass, $db);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $book_name = !empty(trim($_POST['book_name'])) ? trim($_POST['book_name']) : '';
                $author_name = !empty(trim($_POST['author_name'])) ? trim($_POST['author_name']) : '';

                $sql = "SELECT * FROM books WHERE book_name LIKE ? OR author_name LIKE ?";
                $stmt = $conn->prepare($sql);

                $search_book_name = "%" . $book_name . "%";
                $search_author_name = "%" . $author_name . "%";
                $stmt->bind_param("ss", $search_book_name, $search_author_name);

                if ($stmt->execute()) {
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $search_results[] = $row;
                        }
                    }
                } else {
                    echo "Error executing query: " . $stmt->error;
                }

                $stmt->close();
                $conn->close();
            }
            ?>

            <!-- Display Search Results -->
            <div id="search-results">
                <?php if (!empty($search_results)) : ?>
                    <h4>Search Results:</h4>
                    <ul class="list-group">
                        <?php foreach ($search_results as $book) : ?>
                            <li class="list-group-item">
                                <strong>Book Name:</strong> <?php echo htmlspecialchars($book['book_name']); ?><br>
                                <strong>Author:</strong> <?php echo htmlspecialchars($book['author_name']); ?><br>
                                <strong>Publisher:</strong> <?php echo htmlspecialchars($book['publication']); ?><br>
                                <strong>Edition:</strong> <?php echo htmlspecialchars($book['edition']); ?><br>
                                <strong>Price:</strong> <?php echo htmlspecialchars($book['price']); ?><br>
                                <strong>Availability:</strong> <?php echo htmlspecialchars($book['availability']) ? '1' : '0'; ?><br>
                                <strong>1 means available, 0 means not available</strong><br>
                                <?php if ($book['availability'] == 1) : ?>
                                    <a href="rent.php" class="btn btn-success">Rent</a>
                                <?php else : ?>
                                    <a href="notify.php" class="btn btn-warning">Notify</a>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php elseif (isset($_POST['search'])) : ?>
                    <div class="alert alert-warning">No results found.</div>
                <?php endif; ?>
            </div>

        </div>
    </div>

</body>

</html>
