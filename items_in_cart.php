<?php

session_start();
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
// Initialize cart items variable
// $cart_items = [];
$user_id = $_SESSION["user_id"];
// retrieve cart id
$sql = "SELECT cart_id FROM carts WHERE user_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt-> execute();
$stmt->bind_result($cart_id);
$stmt->fetch();
$stmt->close();

// Fetch cart items
$cart_items = getCartItems($conn, $cart_id);
$address = getAddress($conn, $user_id);

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
    if ((isset($_POST['start-order'])) &&  (!$address)){
        $order_id = startOrder($conn, $user_id, $cart_id);
        $address = getAddress($conn, $user_id);
        echo 'Ordered successfully to address ' . $address . '. Your order ID is '. $order_id;
    }
    // update cart_items
    $cart_items = getCartItems($conn, $cart_id);
}
// Close connection
$conn->close();


/////////////////////////////////////////
// get cart items
function getCartItems($conn, $cart_id) {
    $sql = "SELECT ci.cart_item_id, ci.quantity, i.item_name, i.price, i.image_url
    FROM cart_items ci JOIN items i 
    ON ci.item_id = i.item_id
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
    $sql = "UPDATE cart_items SET quantity = ? WHERE cart_item_id = ?;";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $quantity, $cart_item_id);
    $stmt->execute();
    $stmt->close();
}

// remove item form cart
function deleteCartItem($conn, $cart_item_id) {
    $sql = "DELETE FROM cart_items WHERE cart_item_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cart_item_id);
    $stmt->execute();
    $stmt->close();
}
// order 
function startOrder($conn, $user_id, $cart_id) {
    $sql = "INSERT INTO orders(user_id, status) VALUES (?, 'Pending')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $order_id = $stmt->insert_id;
    $stmt->close();

    // move items from cart to order
    $sql="INSERT INTO order_items (order_id, item_id, quantity, price)
            SELECT ?, ci.item_id, ci.quantity, i.price
            FROM cart_items ci
            JOIN items i ON ci.item_id = i.item_id
            WHERE ci.cart_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $order_id, $cart_id);
    $stmt->execute();
    $stmt->close();

    //clear the cart after order
    $sql= "DELETE FROM cart_items WHERE cart_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cart_id) ;
    $stmt->execute();
    $stmt->close();

    return $order_id;
}

// get address to complete order
function getAddress($conn, $user_id) {
    $sql = "SELECT address FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $address = $stmt->get_result();
    $address = $address->fetch_assoc();
    $stmt->close();
    return $address["address"];
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
                <!-- the damn bar -->
                <input type="text" placeholder="What do you want to buy~">
                <button type="submit">Search</button>
            </div>
            <div id="signin-signup">
                <img src="pictures/user_1177568.png" alt="user" id="user">
                <?php if(isset($_SESSION["user_id"])):?>
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
                        <td><?php echo htmlspecialchars($item['item_name']); ?></td>
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
            <!-- order button -->
            <form action="" method="POST">
                <button type="submit" name="start-order">Order</button>
            </form>
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

