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

/////////////////////////////////////////
// get cart items
function getCartItems($conn, $cart_id) {
    $sql = "SELECT ci.cart_item_id, ci.quantity, i.item_name, i.price, i.image_url
    FROM cart_items ci
    JOIN items i ON ci.item_id = i.item_id
    WHERE ci.cart_id =?";
    $stmt = $conn   ->prepare($sql);
    $stmt->bind_param("i", $cart_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $items = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $items;
}
// when user clicked button, update item quantity
function updateItemQuantity($conn, $cart_item_id, $quantity) {
    $sql = "UPDATE cart-items SET quantity = ? WHERE cart-item-id = ?;";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $cart_item_id);
    $stmt->execute();
    $stmt->close();
}

// remove item form cart
function deleteCartItem($conn, $cart_item_id) {
    $sql = "DELETE FROM cart-items WHERE cart-item-id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cart_item_id);
    $stmt->execute();
    $stmt->close();
}

// Initialize cart items variable
// $cart_items = [];

// Assuming you have a cart_id (usually you get this from session or user authentication)
$cart_id = 1; // Example cart_id, replace with actual logic

// Fetch cart items
$cart_items = getCartItems($conn, $cart_id);

// form submissions for updating quantity and deleting items
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update_quantity'])) {
        $cart_item_id = $_POST['cart_item_id'];
        $quantity = $_POST['quantity'];
        updateItemQuantity($conn, $cart_item_id, $quantity);
    }
    if (isset($_POST['delete_item'])) {
        $cart_item_id = $_POST['cart_item_id'];
        deleteCartItem($conn, $cart_item_id);
    }
    // update cart_items
    $cart_items = getCartItems($conn, $cart_id);
}
// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/the-real-shopee/sites/styles.css">
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
                <!-- the damn bar -->
                <input type="text" placeholder="What do you want to buy~">
                <button type="submit">Search</button>
            </div>
            <div id="signin-signup">
                <img src="pictures/user_1177568.png" alt="user" id="user">
                <a href="/the-real-shopee/signup.php" class="user-login">Sign up</a>
                <a href="/the-real-shopee/signin.php" class="user-login">Sign in</a>
            </div>
            <div id="shopping-cart">
                <a href="items_in_cart.php">
                    <img src="pictures/trolley_4290854.png" alt="cart" id="cart">
                </a>
            </div>
        </div>

        <div class="main">
            <?php if (count($cart_items) > 0): ?>
            <table>
                <tr>
                    <th>Product Image</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($cart_items as $item) : ?>
                    <tr>
                        <td><img src="<?php echo htmlspecialchars($item['image_url']); ?>" alt="image" height="50px"></td>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td><?php echo number_format($item['price']); ?></td>
                        <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                        <td><?php echo number_format($item['price']*$item['quantity']); ?></td>
                        <td>
                            <!-- Form to update quantity -->
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="cart_item_id" value="<?php echo $item['cart_item_id']; ?>">
                                <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1">
                                <button type="submit" name="update_quantity">Update</button>
                            </form>
                            <?php
    $item_id = $_POST['item_id'];
    $quantity = $_POST['quantity'];
    echo "Item ID: " . $item_id . "<br>";
    echo "Quantity: " . $quantity . "<br>";
    
                            ?>
                            <!-- Form to delete item -->
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="cart_item_id" value="<?php echo $item['cart_item_id']; ?>">
                                <button type="submit" name="delete_item">Delete</button>
                            </form>
                        </td>
                    </tr>

                    <!-- php end each item -->
                    <?php endforeach; ?>
            </table>
            <?php else: ?>
                <p>Empty</p>
            <?php endif; ?>
        </div>


        <div class="contact">
            <table>
                <tr>
                    <th>Follow us</th>
                    <th>Contact us</th>
                    <th>Policy</th>
                </tr>
                <tr>
                    <button ></button>
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

    <script src="/the-real-shopee/sites/item_details.js"></script> 
</body>
</html>

