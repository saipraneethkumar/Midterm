<?php
// Include database connection file
require_once 'dbinit.php'; // Ensure this path is correct

$shoeName = $shoeDescription = $quantityAvailable = $price = "";
$error = "";

// Insert new shoe if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate inputs
    if (empty($_POST['shoeName']) || empty($_POST['shoeDescription']) || empty($_POST['quantityAvailable']) || empty($_POST['price'])) {
        $error = "All fields are required.";
    } else {
        // Sanitize inputs to avoid XSS and injection attacks
        $shoeName = htmlspecialchars(trim($_POST['shoeName']));
        $shoeDescription = htmlspecialchars(trim($_POST['shoeDescription']));
        $quantityAvailable = (int)$_POST['quantityAvailable'];
        $price = (float)$_POST['price'];

        // Check if numeric fields are valid
        if ($quantityAvailable <= 0 || $price <= 0) {
            $error = "Quantity and Price must be positive numbers.";
        } else {
            // Insert into database using prepared statement
            try {
                $stmt = $conn->prepare("INSERT INTO shoes (ShoeName, Description, QuantityAvailable, Price, ProductAddedBy, Size) VALUES (?, ?, ?, ?, ?, ?)");
                $productAddedBy = 'Sai Praneeth'; // Assuming this value
                $size = '10'; // Assuming a default size, you may want to collect this in the form
                $stmt->bind_param("ssidsi", $shoeName, $shoeDescription, $quantityAvailable, $price, $productAddedBy, $size);
                
                if ($stmt->execute()) {
                    echo "<div class='alert alert-success'>New shoe added successfully!</div>";
                } else {
                    throw new mysqli_sql_exception("Error executing query: " . $stmt->error);
                }

                // Close the statement after execution
                $stmt->close();
            } catch (mysqli_sql_exception $e) {
                echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
            }
        }
    }
}

// Fetch shoes from the database
try {
    $result = $conn->query("SELECT * FROM shoes"); // Removed the incorrect 'query:' part
    if ($result->num_rows > 0) {
        $shoes = $result->fetch_all(MYSQLI_ASSOC);  // Fetch all shoes as an associative array
    } else {
        $shoes = [];
    }

    // Free result set
    $result->free();

} catch (mysqli_sql_exception $e) {
    echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
}

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Shoe</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <nav>
    <a href="home.html">Home</a>  |
    <a href="insert.php">Add New Shoe</a> |
    <a href="retrieve.php">View Shoes</a> |
    <a href="update.php">Update Shoes</a> |
    <a href="delete.php">Delete Shoes</a>
</nav>

</head>
<body>
<div class="container">
    <h2>Add a New Shoe</h2>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="form-group">
            <label for="shoeName">Shoe Name</label>
            <input type="text" class="form-control" id="shoeName" name="shoeName" value="<?= $shoeName ?>" required>
        </div>
        <div class="form-group">
            <label for="shoeDescription">Description</label>
            <textarea class="form-control" id="shoeDescription" name="shoeDescription" required><?= $shoeDescription ?></textarea>
        </div>
        <div class="form-group">
            <label for="quantityAvailable">Quantity Available</label>
            <input type="number" class="form-control" id="quantityAvailable" name="quantityAvailable" value="<?= $quantityAvailable ?>" required>
        </div>
        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?= $price ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Shoe</button>
    </form>
    <h2>Shoe Inventory</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ShoeID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Added By</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($shoes)): ?>
                <?php foreach ($shoes as $shoe): ?>
                    <tr>
                        <td><?= $shoe['ShoeID'] ?></td>
                        <td><?= $shoe['ShoeName'] ?></td>
                        <td><?= $shoe['Description'] ?></td>
                        <td><?= $shoe['QuantityAvailable'] ?></td>
                        <td><?= number_format($shoe['Price'], 2) ?></td>
                        <td><?= $shoe['ProductAddedBy'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No shoes found in the inventory.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>                                                                                                                     
