<?php

require_once("cors.php");

$rawPostData = file_get_contents('php://input');

if (empty($rawPostData)) {
    $array = array(
        "err" => "bad request, no data"
    );
    $jsonData = json_encode($array);
    header('Content-type: application/json');
    echo $jsonData;
    exit();
}

$postData = json_decode($rawPostData, true);

if (empty($postData) || !isset($postData['login']) || !isset($postData['email']) || !isset($postData['password'])) {
    $array = array(
        "err" => "bad request, no login, email or password"
    );
    $jsonData = json_encode($array);
    header('Content-type: application/json');
    echo $jsonData;
    exit();
}

$login = $postData['login'];
$email = $postData['email'];
$password = $postData['password'];
$hash = password_hash($password, PASSWORD_DEFAULT);

$mysql = new mysqli('localhost', 'root', '', 'dailytasks');

if($mysql->connect_error) {
    $array = array(
        "err" => "database error"
    );
    $jsonData = json_encode($array);
    header('Content-type: application/json');
    echo $jsonData;
    exit();
}

if(empty($login) || empty($email) || empty($password)) {
    $array = array(
        "err" => "bad request, no login, email or password"
    );
    $jsonData = json_encode($array);
    header('Content-type: application/json');
    echo $jsonData;
    exit();
}

if(filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
    $array = array(
        "err" => "bad email"
    );
    $jsonData = json_encode($array);
    header('Content-type: application/json');
    echo $jsonData;
    exit();
}

$sql = "SELECT user_id FROM users WHERE login = '$login' OR email = '$email'";
$result = $mysql->query($sql);

if ($result->num_rows > 0) {
    $array = array(
        "err" => "user or email already exists"
    );
    $jsonData = json_encode($array);
    header('Content-type: application/json');
    echo $jsonData;
    exit();
}

$sql = "INSERT INTO users (login, email, password) VALUES ('$login', '$email', '$hash')";
$mysql->query($sql);

$array = array(
    "response" => "user created"
);
$jsonData = json_encode($array);
header('Content-type: application/json');
echo $jsonData;
$mysql->close();