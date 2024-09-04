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

$itemid= (int)$_GET['category']
// Database connection parameters
$servername = "localhost";
$username = "system";
$password = "12345";
$dbname = "ecommerce_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn -> connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch data
$sql = "SELECT * FROM `items` WHERE 'category_id'=$_GET['category'] ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>category id</th>
                <th>name</th>
                <th>description</th>
            </tr>";
    
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        
        echo "<tr>
                <td>" . $row["id"] . "</td>
                <td>" . $row["category_id"] . "</td>
                <td>" . $row["name"] . "</td>
                <td>" . $row["description"] . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

// Close connection
$conn->close();
?>

</body>
</html>
