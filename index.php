<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP MySQL Fetch Example</title>
</head>
<body>

<h1>Category List</h1>

<?php
// Database connection parameters
$servername = "localhost";
$username = "system";
$password = "12345";
$dbname = "ecommerce_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch data
$sql = "SELECT * FROM `categories`";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Status</th>
            </tr>";
    
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        if ($row['is_active'] == 1) {
            // Create a link to the items list page
            $category_name = htmlspecialchars($row["name"]);
            echo "<tr>
                    <td>" . $row["id"] . "</td>
                    <td><a href='items.php?category=" . urlencode($category_name) . "'>" . $row["name"] . "</a></td>
                    <td>" . $row["is_active"] . "</td>
                  </tr>";
        }
    }
    echo "</table>";
} else {
    echo "0 results";
}

// Close connection
$conn->close();
?>
<!-- Floating Cart HTML -->
<div id="floating-cart">
    <h3>Cart</h3>
    <p>Your cart is empty.</p>
    <button onclick="window.location.href='cart.php'">View Cart</button>
</div>


</body>
</html>
