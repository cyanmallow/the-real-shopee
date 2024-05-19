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
// <form action="add-item.php" class="add-field">
// <label for="name">Name: </label><br>
// <input type="text" maxlength="50"><br>

// <label for="description">Description: </label><br>
// <input type="text" maxlength="225"><br>

// <label for="quantity">Quantity: </label><br>
// <input type="number"><br>

// <label for="price">Price: </label><br>
// <input type="number"><br><br>

// <input type="submit" value="Submit data">
// </form>
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $name = $_POST['name'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    // SQL to insert a record
    $sql = "INSERT INTO users (name, description, quantity, price)
    VALUES ('$name', '$description', '$quantity', '$price')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
