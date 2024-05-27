<?php
$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $conn = require __DIR__ ."/database.php";

    $sql = sprintf("SELECT * FROM users WHERE username ='%s'", $conn->real_escape_string($_POST["username"]));
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();
    
    if ($user){
        if (password_verify($_POST["password"], $user["password_hash"])){
            session_start();
            $_SESSION["user_id"] = $user["user_id"];


            // add cart
    // check if user has an existing cart
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
    $_SESSION['cart_id'] = $cart_id; // Store cart_id in session
    $stmt->close();



            header("Location: index.php");
            exit;
        }
    }
    $is_invalid = true;
}
function createNewCart($conn, $user_id) {
    $sql = "INSERT INTO carts (user_id) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $cart_id = $stmt-> insert_id;
    $stmt-> close();
    return $cart_id;
}    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in</title>
    <link rel="stylesheet" href="/the-real-shopee/sites/signin.css">
    <link rel="stylesheet" href="https://unpkg.com/mvp.css"> 
</head>
<body>
    <div id="container">
        <div class="upper-bar">
            <div class="logo">
                <a href="index.php">
                    <img src="/the-real-shopee/pictures/logo-white.png" alt="logo" height="200px" width="200px">
                </a>          
            </div>
        </div>

        <div class="login">
            <?php if ($is_invalid):?>
                <em>Invalid login</em>
            <?php endif;?>


            <form class="add-field" method="POST" id="sign-in">
                <label for="username" id="username">Username: </label><br>
                <input type="text" maxlength="50" name="username"><br>
    
                <label for="password" id="password">Password: </label><br>
                <input type="password" maxlength="225" name="password"><br>

                <input type="submit" value="Sign in">

            </form>
            No accounts yet?  <a href="signup.php">Sign up</a> now!
        
        </div>

        
    </div>

</body>
</html>