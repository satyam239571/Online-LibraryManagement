<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: login.html");
    exit;
}

// Get the user_id from session (assuming it's stored when the user logs in)
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

// Database connection
$server = "localhost";
$user = "root";
$pass = "";
$db = "lms";
$conn = new mysqli($server, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);

}
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


// SQL query to fetch rented books and details
$sql = "SELECT b.book_id, b.book_name, b.author_name, b.publication, b.edition, r.start_date, r.end_date, b.availability
        FROM rentals r
        JOIN books b ON r.book_id = b.book_id
        WHERE r.user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);  // Bind the user_id to the query

if ($stmt->execute()) {
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<h2>Your Rented Books</h2>";
        echo "<table class='table table-bordered'>";
        echo "<thead><tr>
                <th>Book ID</th>
                <th>Book Name</th>
                <th>Author Name</th>
                <th>Publication</th>
                <th>Edition</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Availability</th>
              </tr></thead><tbody>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['book_id']) . "</td>";
            echo "<td>" . htmlspecialchars($row['book_name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['author_name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['publication']) . "</td>";
            echo "<td>" . htmlspecialchars($row['edition']) . "</td>";
            echo "<td>" . htmlspecialchars($row['start_date']) . "</td>";
            echo "<td>" . htmlspecialchars($row['end_date']) . "</td>";
            echo "<td>" . ($row['availability'] == 1 ? 'Available' : 'Not Available') . "</td>";
            echo "</tr>";
        }

        echo "</tbody></table>";
    } else {
        echo "<p>No books rented by you currently.</p>";
    }
} else {
    echo "Error fetching rentals: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>

<!-- Bootstrap CSS for table styling -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Rented Books</title>
</head>
<body>
<div class="container mt-4">
    <!-- The table and result will be displayed here -->
</div>
</body>
</html>