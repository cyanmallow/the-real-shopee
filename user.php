<!-- moved to change user's data -->
<?php
session_start();
$conn = require __DIR__ ."/database.php";

$user_id = $_SESSION["user_id"];

// fetch username and address
$sql = "SELECT username, address FROM users WHERE user_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username, $address);
$stmt->fetch();
$stmt->close();

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/the-real-shopee/sites/styles.css">
    <link rel="stylesheet" href="https://unpkg.com/mvp.css"> 
    <title>Change address</title>
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
            <?php 
                echo "Username: ". $username; ?><br><?php
                echo "User ID: ". $user_id; ?><br><?php
                echo "Address: ". $address; ?><br><?php
            ?>
            <form action="change_user_data.php" method="POST">
                <input type="text" name="new_address" placeholder="New address">
                <button type="submit">Change</button>
            </form>
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

