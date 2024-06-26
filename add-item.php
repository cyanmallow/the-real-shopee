<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add items for seller</title>
    <link rel="stylesheet" href="/the-real-shopee/sites/signin.css">
    <link rel="stylesheet" href="https://unpkg.com/mvp.css"> 

</head>
<body>
    <div id="container">
        <div class="upper-bar">
            <div class="logo">
                <a href="/the-real-shopee/index.php">
                    <img src="/the-real-shopee/pictures/logo-white.png" alt="logo" height="200px" width="200px">
                </a>
            </div>
        </div>

        <div class="login">
            <form action="" class="add-field" method="POST">
                <label for="category">Category: </label><br>
                <select id="category" name="category">
                    <option value="baghook">Baghook<br>
                    <option value="bean">Bean<br>
                    <option value="figure">Figure<br>
                    <option value="metalpin">Metal Pin<br>                
                    <option value="rabbit">Rabbit<br>
                    <option value="others">Others<br>
                </select>

                <label for="name">Item name: </label><br>
                <input type="text" maxlength="50" name="item_name"><br>
    
                <label for="description">Item description: </label><br>
                <input type="text" maxlength="225" name="description"><br>
    
                <label for="quantity">Quantity: </label><br>
                <input type="number" name="quantity"><br>
    
                <label for="price">Price: </label><br>
                <input type="number" name="price"><br><br>

                <label for="image_url">Image link: </label><br>
                <input type="text" maxlength="225" name="image_url"><br>
    
                <input type="submit" value="Submit data">

            </form> 
            
            <!-- process the above form -->
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

// Get form data
$category = $_POST['category'];
$item_name = $_POST['item_name'];
$description = $_POST['description'];
$price = $_POST['price'];
$quantity = $_POST['quantity'];
$image_url = $_POST['image_url'];

// Insert data into database
$sql = "INSERT INTO items (category, item_name, description, price, quantity, image_url)
        VALUES ('$category', '$item_name', '$description', '$price', '$quantity', '$image_url')";

if ($conn->query($sql) === TRUE) {
    echo "New item added successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$conn->close();


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