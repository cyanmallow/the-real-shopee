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
                <!-- trending items -->
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
            
        <!-- database -->
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
                echo "<button id='cart' type='submit'>Add to cart</button>";
                echo "<button id='buy' type='submit'>Buy now</button>";
                echo "</div>";
                echo "<title>" . htmlspecialchars($item["item_name"]) . "</title>";

                // add item to cart 
                $sql = "INSERT INTO cart_items (cart_id, item_id, quantity)
                        VALUES ('$category', '$item_name', '$description', '$price', '$quantity', '$image_url')";
                
                if ($conn->query($sql) === TRUE) {
                    echo "Added to cart";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }


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

    <script src="/the-real-shopee/sites/script.js"></script> 
</body>
</html>