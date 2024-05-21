<?php
if (isset($_POST['category'])) {
    $category = $_POST['category'];

    // Database connection details
    $servername = "localhost";
    $username = "root"; 
    $password = ""; 
    $dbname = "shopping-db"; 

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the query
    $sql = $conn->prepare("SELECT item_name, description, price, quantity, image_url FROM items WHERE category = ?");
    if ($sql) {
        $sql->bind_param("s", $category);
        $sql->execute();
        $result = $sql->get_result();

        if ($result) {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='each-item'>";
                    echo "Name: " . $row["item_name"] . "<br>";
                    echo "Description: " . $row["description"] . "<br>";
                    echo "Price: " . $row["price"] . "<br>";
                    echo "Quantity: " . $row["quantity"] . "<br>";
                    echo "<img src='" . $row["image_url"] . "' alt='Image of " . $row["item_name"] . "'><br>";
                    echo "</div>";
                }
            } else {
                echo "0 results";
            }
        } else {
            echo "Error: " . $conn->error;
        }
        $sql->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

    $conn->close();
} else {
    echo "No category selected.";
}
?>
