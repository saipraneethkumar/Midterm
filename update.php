<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Shoe</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="styles.css">

    <nav>
    <a href="home.html">Home</a>  |
    <a href="insert.php">Add New Shoe</a> |
    <a href="retrieve.php">View Shoes</a> |
    <a href="update.php">Update Shoes</a> |
    <a href="delete.php">Delete Shoes</a>
</nav>
</head>
<body>

<?php
$servername = "localhost";
$username = "root";
$password = "saichinnu123@";
$dbname = "sai_praneeth";

// Create connection and check for errors
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("<div class='error-message'>Connection failed: " . $conn->connect_error . "</div>");
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs
    $shoe_id = filter_var($_POST['shoe_id'], FILTER_VALIDATE_INT);
    $shoe_name = trim($_POST['shoe_name']);
    $description = trim($_POST['description']);
    $quantity = filter_var($_POST['quantity'], FILTER_VALIDATE_INT);
    $price = filter_var($_POST['price'], FILTER_VALIDATE_FLOAT);
    $size = trim($_POST['size']);

    // Validate required fields
    if ($shoe_id === false || empty($shoe_name) || $quantity === false || $price === false || empty($size)) {
        echo "<div class='error-message'>Please fill in all required fields correctly.</div>";
    } else {
        // Prepare the SQL update statement
        $stmt = $conn->prepare("UPDATE shoes SET ShoeName=?, Description=?, QuantityAvailable=?, Price=?, Size=? WHERE ShoeID=?");

        if ($stmt) {
            // Bind parameters to the statement
            $stmt->bind_param("ssidsi", $shoe_name, $description, $quantity, $price, $size, $shoe_id);

            // Execute the statement and check if it was successful
            if ($stmt->execute()) {
                echo "<div class='success-message'>Shoe updated successfully!</div>";
            } else {
                echo "<div class='error-message'>Error updating shoe: " . $stmt->error . "</div>";
            }

            // Close the statement
            $stmt->close();
        } else {
            echo "<div class='error-message'>Error preparing statement: " . $conn->error . "</div>";
        }
    }
}

// Close the connection
$conn->close();
?>

<!-- HTML Form for updating the shoe details -->
<form method="POST" action="" class="sai">
    <h2>Update Shoe Details</h2>

    <label for="shoe_id">Shoe ID:</label>
    <input type="number" id="shoe_id" name="shoe_id" required>

    <label for="shoe_name">Shoe Name:</label>
    <input type="text" id="shoe_name" name="shoe_name" required>

    <label for="description">Description:</label>
    <textarea id="description" name="description"></textarea>

    <label for="quantity">Quantity Available:</label>
    <input type="number" id="quantity" name="quantity" required>

    <label for="price">Price:</label>
    <input type="number" step="0.01" id="price" name="price" required>

    <label for="size">Shoe Size:</label>
    <input type="text" id="size" name="size" required>

    <input type="submit" value="Update Shoe">
</form>

</body>
</html>
