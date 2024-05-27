<?php 
session_start();
print_r($_SESSION);

function createNewCart($mysqli, $user_id) {
    $sql = "INSERT INTO carts (user_id) VALUES ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $cart_id = $stmt-> insert_id;
    $stmt-> close();
    return $cart_id;
}
// get $user_id
$user_id = $_SESSION["user_id"];

// check if cart_id is in session
if (!isset($_SESSION["cart_id"])) {
    $mysqli = require __DIR__ ."/database.php";
    $cart_id = createNewCart($mysqli, $user_id);
    $_SESSION["cart_id"] = $cart_id;
} else {
    $cart_id = $_SESSION["cart_id"];
}

echo"Cart ID: ". $cart_id;
?>