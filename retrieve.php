<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shoe Inventory</title>
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
    <h2>Shoe Inventory</h2>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "saichinnu123@";
    $dbname = "sai_praneeth";

    // Create connection and check for errors
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check if connection was successful
    if ($conn->connect_error) {
        die("<div class='alert alert-danger'>Connection failed: " . $conn->connect_error . "</div>");
    }

    // Select all shoes from the database
    $sql = "SELECT ShoeID, ShoeName, Description, QuantityAvailable, Price, Size FROM shoes";
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result) {
        if ($result->num_rows > 0) {
            echo "<table class='table'>
                    <thead>
                        <tr>
                            <th>Shoe ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Size</th>
                        </tr>
                    </thead>
                    <tbody>";
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                // Sanitize output to prevent XSS
                $shoeID = htmlspecialchars($row["ShoeID"]);
                $shoeName = htmlspecialchars($row["ShoeName"]);
                $description = htmlspecialchars($row["Description"]);
                $quantity = htmlspecialchars($row["QuantityAvailable"]);
                $price = htmlspecialchars(number_format($row["Price"], 2));
                $size = htmlspecialchars($row["Size"]);

                echo "<tr>
                        <td>$shoeID</td>
                        <td>$shoeName</td>
                        <td>$description</td>
                        <td>$quantity</td>
                        <td>$$price</td>
                        <td>$size</td>
                      </tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<div class='alert alert-info'>No shoes found.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Error retrieving shoes: " . $conn->error . "</div>";
    }

    // Close the database connection
    $conn->close();
    ?>
</div>
</body>
</html>

