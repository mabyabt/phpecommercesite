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
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection (replace with your own credentials)
$servername = "localhost";
$username = "system";
$password = "12345";
$dbname = "ecommerce_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the category_name from the URL
$category_name = isset($_GET['category']) ? $_GET['category'] : '';

if ($category_name) {
    // Debugging: Print the category name
    echo "Category: " . htmlspecialchars($category_name) . "<br>";

    // Prepare the SQL query to get the category ID based on the name (case-insensitive)
    $sql = "SELECT id FROM categories WHERE LOWER(name) = LOWER(?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $category_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the category ID
        $category = $result->fetch_assoc();
        $category_id = $category['id'];

        // Debugging: Print the category ID
        echo "Category ID: " . $category_id . "<br>";

        // Query to get products based on the category ID
        $sql = "SELECT * FROM items WHERE category_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $category_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Display the products
        if ($result->num_rows > 0) {
            echo "Products found:<br>";
            while ($row = $result->fetch_assoc()) {
                echo "<h2>Product Name: " . $row["name"] . "</h2>";
                echo "<p>Description: " . $row["description"] . "</p>";
                echo "<p>Price: $" . $row["price"] . "</p>";

                // Decode image_urls if it's a JSON array
                $image_urls = json_decode($row["image_urls"], true);

                if (is_array($image_urls)) {
                    foreach ($image_urls as $image_url) {
                        echo "<img src='" . $image_url . "' alt='" . $row["name"] . "' style='max-width: 300px; margin: 10px;' /><br>";
                    }
                } else {
                    // If it's not an array, just show the single image URL
                    echo "<img src='" . $row["image_urls"] . "' alt='" . $row["name"] . "' style='max-width: 300px; margin: 10px;' /><br>";
                }

                echo "<hr>";
            }
        } else {
            echo "No products found for this category.";
        }
    } else {
        echo "Category not found.";
    }

    $stmt->close();
} else {
    echo "No category specified.";
}

$conn->close();
?>


</body>
</html>
