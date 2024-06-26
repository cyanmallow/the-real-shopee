<?php
session_start();
$conn = require __DIR__ ."/database.php";

// Function to create a new cart
function createNewCart($conn, $user_id) {
    $sql = "INSERT INTO carts (user_id) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $cart_id = $stmt->insert_id;
    $stmt->close();
    return $cart_id;
}

function addItemToCart($conn, $cart_id, $item_id, $quantity) {
    // Check if the user is logged in
    if (!isset($_SESSION["user_id"])) {
        // die("You must be logged in to add items to the cart.");
        header("Location: signin.php");
        exit;
    }

    $user_id = $_SESSION["user_id"];

    // Check if user has an existing cart
    $sql = "SELECT cart_id FROM carts WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // User has an existing cart, retrieve it
        $stmt->bind_result($cart_id);
        $stmt->fetch();
    } else {
        // No existing cart, create a new one
        $cart_id = createNewCart($conn, $user_id);
    }
    $stmt->close();

    // Check if the item already exists in the cart
    $sql = "SELECT quantity FROM cart_items WHERE cart_id = ? AND item_id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
        return;
    }

    $stmt->bind_param("ii", $cart_id, $item_id);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        // Item exists, update quantity
        $stmt->bind_result($existing_quantity);
        $stmt->fetch();
        $new_quantity = $existing_quantity + $quantity;
        $update_sql = "UPDATE cart_items SET quantity = ? WHERE cart_id = ? AND item_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        
        if (!$update_stmt) {
            echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
            return;
        }

        $update_stmt->bind_param("iii", $new_quantity, $cart_id, $item_id);
        $update_stmt->execute();
        $update_stmt->close();
    } else {
        // Item does not exist, insert new record
        $insert_sql = "INSERT INTO cart_items (cart_id, item_id, quantity) VALUES (?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        
        if (!$insert_stmt) {
            echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
            return;
        }

        $insert_stmt->bind_param("iii", $cart_id, $item_id, $quantity);
        $insert_stmt->execute();
        $insert_stmt->close();
    }
    
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION["user_id"];
    $cart_id = $_SESSION["cart_id"];

    $item_id = $_POST['item_id'];
    $quantity = $_POST['quantity'];
    addItemToCart($conn, $cart_id, $item_id, $quantity);
    header("Location: items_in_cart.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/the-real-shopee/sites/styles.css">
    <link rel="stylesheet" href="https://unpkg.com/mvp.css"> 

</head>
<body>
    <div class="container">
        <div class="upper-bar">
            <div class="logo">
                <a href="index.php">
                    <img src="/the-real-shopee/pictures/logo-white.png" alt="logo" height="150px" style="margin-left: 10px">
                </a>
            </div>
            <div id="search-bar">
                <form action="search.php" method="GET">
                    <input type="text" placeholder="WIP...">
                    <button type="submit">Search</button>
                </form>
            </div>
            <div id="signin-signup">
                <img src="pictures/user_1177568.png" alt="user" id="user">
                <?php if(isset($_SESSION["user_id"])):?>
                    <a href="/the-real-shopee/user.php" class="user-login">Change address</a>
                    <a href="/the-real-shopee/signout.php" class="user-login">Sign out</a>

                <?php else:?>
                    <a href="/the-real-shopee/signup.php" class="user-login">Sign up</a>
                    <a href="/the-real-shopee/signin.php" class="user-login">Sign in</a>
                <?php endif;?>  
            </div>
            <div id="shopping-cart">
                <a href="items_in_cart.php">
                    <img src="pictures/trolley_4290854.png" alt="cart" id="cart">
                </a>
            </div>
        </div>

        <div class="main">
        <?php
        // Get the item ID from the query parameter
        $item_name = isset($_GET['item_name']) ? ($_GET['item_name']) : '';
        // Prepare and execute the query
        if (!empty($item_name)) {
            $stmt = $conn->prepare("SELECT * FROM items WHERE item_name = ?");
            $stmt->bind_param("s", $item_name);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result -> num_rows > 0) {
                $item = $result -> fetch_assoc();

                // add css flex
                echo "<link rel='stylesheet' href='/the-real-shopee/sites/flex.css'>";

                // add flex
                echo "<div class='flex-container'>";
                echo "<div class='flex-name'>" . $item["item_name"] . "</div>";
                echo "<div class='flex-price'>₫ " . $item["price"] . "</div>";
                echo "<div class='flex-quality'>Only " . $item["quantity"] . " left!! Get yours today!</div>";
                echo "<div class='flex-img'><img src='" . $item["image_url"] . "' alt='Image of " . $item["item_name"] . "'></div>";
                // echo "<input type='hidden' name='item_id' value='" . htmlspecialchars($item["item_id"]) . "'>";

                // add item to cart 
                // Wrap the "Add to Cart" button in a form and 
                // include hidden input fields for item_id and quantity.
                echo "<form class='flex-form' action='item_details.php' method='POST'>";
                echo "<input type='hidden' name='item_id' value='" . htmlspecialchars($item["item_id"]) . "'>";
                echo "<input type='hidden' name='quantity' value='1'>";
        
                echo "<button id='add-to-cart' type='submit'>Add to cart</button>";
                echo "</form>";

                echo "</div>";
                echo "<title>" . htmlspecialchars($item["item_name"]) . "</title>";

            } else {
                echo "Item not found.";
            } 
        } else {
            echo "<title>Invalid item name</title>";
            echo "Invalid item name.";
        }
        ?>
        </div>

        <div class="description">
            <h2>Description</h2>
            <?php
                echo "<div class='flex-description'><br>" . $item["description"] . "</div>";
            ?>
        </div>

        <div class="contact">
            <table>
                <tr>
                    <th>Follow us</th>
                    <th>Contact us</th>
                    <th>Policy</th>
                </tr>
                <tr>
                    <td><a href="https://github.com/cyanmallow">Github</a></td>
                    <td>ggmmallow@gmail.com</td>
                    <td>Terms & Conditions</td>
                </tr>
                <tr>
                    <td><a href="https://x.com/MostimaGinger">X</a></td>
                    <td><a href="https://www.facebook.com/moscult/">Facebook</a></td>
                    <td>Shipping Policy</td>

                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>Exchange and Return</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>VAT Policy</td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>