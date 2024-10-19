<?php
session_start();


if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: login.html");
    exit;
}

// Check if user_id is set in the session



// Database connection
$server = "localhost";
$user = "root";
$pass = "";
$db = "lms";
$conn = new mysqli($server, $user, $pass, $db);

// Check connection

$user_id=1;
$book_id=1;


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming you have the username of the logged-in user stored in session
if (isset($_SESSION['name'])) {
    $name = $_SESSION['name'];

    // Prepare SQL query to fetch user_id from the userlogin table based on the username
    $sql = "SELECT user_id FROM userlogin WHERE name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $name);  // "s" means string (username is a string)

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Fetch the user_id from the result
            $row = $result->fetch_assoc();
            $user_id = $row['user_id'];  // Storing the user_id
            echo "$user_id";

            // Store the user_id in the session for further use
            $_SESSION['user_id'] = $user_id;

         
        }
    }
} 
if (isset($_SESSION['book_name'])) {
    $book_name = $_SESSION['book_name'];

    // Prepare SQL query to fetch user_id from the userlogin table based on the username
    $sql = "SELECT book_id FROM userlogin WHERE book_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $book_name);  // "s" means string (username is a string)

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Fetch the user_id from the result
            $row = $result->fetch_assoc();
            $book_id = $row['book_id'];  // Storing the user_id
            echo "$book_id";

            // Store the user_id in the session for further use
            $_SESSION['book_id'] = $book_id;

         
        }
    }
}


// Handle rental submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Validate dates
    if (strtotime($end_date) < strtotime($start_date)) {
        echo "End date must be after start date.";
        exit;
    }

    // Update availability of the book
   // Update availability of the book
    $sql_update = "UPDATE books SET availability = 0 WHERE book_id = ?"; // Changed id to book_id
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("i", $book_id);

    if ($stmt_update->execute()) {
        // Insert rental record
        $sql_rent = "INSERT INTO rentals (user_id, book_id, start_date, end_date) VALUES (?, ?, ?, ?)";
        $stmt_rent = $conn->prepare($sql_rent);
        $stmt_rent->bind_param("iiss", $user_id, $book_id, $start_date, $end_date);

        if ($stmt_rent->execute()) {
            echo "Book rented successfully!";
        } else {
            echo "Error renting the book: " . $stmt_rent->error;
        }
    } else {
        echo "Error updating book availability: " . $stmt_update->error;
    }

    $stmt_update->close();
    $stmt_rent->close();

}

// Check for overdue fines and update user
function checkAndApplyFine($conn, $user_id) {
    $sql = "SELECT end_date FROM rentals WHERE user_id = ? AND end_date < NOW() AND returned = 0";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $fine = 0;

        while ($row = $result->fetch_assoc()) {
            $overdue_days = (strtotime('now') - strtotime($row['end_date'])) / (60 * 60 * 24);
            $fine += $overdue_days * 50; // 50 rupees per day
        }

        // Update user's fine if any
        if ($fine > 0) {
            $sql_update_fine = "UPDATE userlogin SET fine = fine + ? WHERE id = ?";
            $stmt_update_fine = $conn->prepare($sql_update_fine);
            $stmt_update_fine->bind_param("ii", $fine, $user_id);
            $stmt_update_fine->execute();
            $stmt_update_fine->close();
            echo "Fine of Rs. " . $fine . " applied for overdue books.";
        }
    }
    $stmt->close();
}

// Call the fine checking function
checkAndApplyFine($conn, $user_id);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent Book</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h2>Rent a Book</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label for="start_date">Start Date:</label>
            <input type="date" class="form-control" name="start_date" required>
        </div>
        <div class="form-group">
            <label for="end_date">End Date:</label>
            <input type="date" class="form-control" name="end_date" required>
        </div>
        <button type="submit" class="btn btn-primary">Rent Book</button>
        <?php
        header("location: dashstu.php");
        ?>

    </form>
</div>
</body>
</html>