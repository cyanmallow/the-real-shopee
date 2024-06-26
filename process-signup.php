<?php
if (empty($_POST["username"])) {
    die("Input your username already..");
} 
if (strlen($_POST["password"]) < 8) {
    die("Password must contain at least 8 characters >:(");
}
if ($_POST["password"] !== $_POST["repeat_password"]){
    die("The 2 passwords field do not match.");
}

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

$mysqli = require __DIR__ ."/database.php";

$sql = "INSERT INTO users(username, password_hash, address)
        VALUES (?,?,?)";

$stmt = $mysqli->stmt_init();


if ( !$stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}

$stmt->bind_param("sss", $_POST["username"], $password_hash, $_POST["address"]);
if ($stmt->execute()){
    header("Location: signup-success.php");
    exit;
} else {
    die("error: ". $mysqli->error);
};

?>