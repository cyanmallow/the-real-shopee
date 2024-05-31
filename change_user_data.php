<?php
session_start();
$conn = require __DIR__ ."/database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION["user_id"])) {
        die("You must be logged in to change the address.");
    }

    $user_id = $_SESSION["user_id"];
    $new_address = $_POST["new_address"];

    // Update address in the database
    $sql = "UPDATE users SET address=? WHERE user_id=?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
        exit();
    }
    $stmt->bind_param("si", $new_address, $user_id);
    $stmt->execute();
    $stmt->close();

    header("Location: user.php");
    exit();
}

// Close connection
$conn->close();
?>
