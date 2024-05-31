<?php
if (isset($_POST['category'])) {
    $category = $_POST['category'];
    
    $conn = require __DIR__ ."/database.php";

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
                    echo "<a href='item_details.php?item_name=" .$row['item_name']."'>";
                    echo "<img src='" . $row["image_url"] . "' alt='Image of " . $row["item_name"] . "'><br>";
                    echo "" . $row["item_name"] . "<br>";
                    echo "" . $row["price"] . " dong<br>";
                    echo "" . $row["quantity"] . " left<br>";
                    echo "</a>";
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
