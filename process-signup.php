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

$sql = "INSERT INTO users(username, password_hash)
        VALUES (?,?)";

$stmt = $mysqli->stmt_init();


if ( !$stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}

$stmt->bind_param("ss", $_POST["username"], $password_hash);
if ($stmt->execute()){
    echo"Sign up successful! Log in now!";
} else {
    die("error: ". $mysqli->error);
};

?>