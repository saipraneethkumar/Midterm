<nav>
   <a href="home.html">Home</a>  |
    <a href="insert.php">Add New Shoe</a> |
    <a href="retrieve.php">View Shoes</a> |
    <a href="update.php">Update Shoes</a> |
    <a href="delete.php">Delete Shoes</a>
</nav>

<?php
$servername = "localhost";
$username = "root";
$password = "saichinnu123@";
$dbname = "sai_praneeth";

// Create connection and check for errors
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize the shoe_id
    $shoe_id = filter_var($_POST['shoe_id'], FILTER_VALIDATE_INT);
    
    if ($shoe_id === false) {
        echo "Invalid Shoe ID. Please enter a valid number.";
    } else {
        // Prepare and execute the DELETE statement
        $stmt = $conn->prepare("DELETE FROM shoes WHERE ShoeID = ?");
        $stmt->bind_param("i", $shoe_id);

        // Execute the query and handle any errors
        if ($stmt->execute()) {
            echo "Shoe deleted successfully!";
        } else {
            echo "Error deleting shoe: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }
}

// Close the database connection
$conn->close();
?>

<!-- HTML Form to delete a shoe -->
<form method="POST" action="">
    <label for="shoe_id">Shoe ID:</label>
    <input type="number" id="shoe_id" name="shoe_id" required><br>
    <input type="submit" value="Delete Shoe">
</form>
<link rel="stylesheet" href="stylee.css">
<link rel="stylesheet" href="style.css">



