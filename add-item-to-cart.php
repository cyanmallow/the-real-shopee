<?php
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

    // cart_id :(
    $cart_id = 1;
    echo "Form submitted!";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $item_id = $_POST['item_id'];
        $quantity = $_POST['quantity'];
    
        // Add item to cart
        $sql = "INSERT INTO cart_items (cart_id, item_id, quantity) VALUES (?, ?, ?)
                ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $cart_id, $item_id, $quantity);
        $stmt->execute();
        $stmt->close();
    }
    
    $conn->close();
    
    // Redirect to cart page or any other page
    header("Location: items_in_cart.php");
    exit();

?>
