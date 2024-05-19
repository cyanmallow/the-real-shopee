<?php


// Database connection details
$servername = "localhost";
$username = "sa"; // Replace with your MySQL username
$password = "MiraiNikki1811"; // Replace with your MySQL password
$dbname = "sql_server_container"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$item_name = $_POST['item_name'];
$description = $_POST['description'];
$price = $_POST['price'];
$quantity = $_POST['quantity'];

// Insert data into database
$sql = "INSERT INTO items (item_name, description, price, quantity)
        VALUES ('$item_name', '$description', '$price', '$quantity')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$conn->close();

// Assuming you have established a database connection
$result = mysqli_query($conn, "SELECT * FROM items");
while ($row = mysqli_fetch_assoc($result)) {
    echo "<div>";
    echo "<h2>" . $row['item_name'] . "</h2>";
    echo "<p>Description: " . $row['description'] . "</p>";
    echo "<p>Price: $" . $row['price'] . "</p>";
    echo "<p>Quantity available: " . $row['quantity'] . "</p>";
    echo "</div>";
}