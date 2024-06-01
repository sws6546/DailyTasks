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

$data = json_decode($rawPostData, true);

if (!isset($data['login']) || !isset($data['password'])) {
    $array = array(
        "err" => "bad request, no login or password"
    );
    $jsonData = json_encode($array);
    header('Content-type: application/json');
    echo $jsonData;
    exit();
}

$login = $data['login'];
$password = $data['password'];

$mysql = new mysqli('localhost', 'root', '', 'dailytasks');

if ($mysql->connect_error) {
    $array = array(
        "err" => "database error"
    );
    $jsonData = json_encode($array);
    header('Content-type: application/json');
    echo $jsonData;
    exit();
}

if (empty($login) || empty($password)) {
    $array = array(
        "err" => "bad request, no login or password"
    );
    $jsonData = json_encode($array);
    header('Content-type: application/json');
    echo $jsonData;
    exit();
}

$sql = "SELECT * FROM users WHERE login = '$login'";
$result = $mysql->query($sql);

if ($result->num_rows == 0) {
    $array = array(
        "err" => "user not found"
    );
    $jsonData = json_encode($array);
    header('Content-type: application/json');
    echo $jsonData;
    exit();
}

$row = $result->fetch_assoc();

if (!password_verify($password, $row['password'])) {
    $array = array(
        "err" => "bad password"
    );
    $jsonData = json_encode($array);
    header('Content-type: application/json');
    echo $jsonData;
    exit();
}

// return jwt
require_once __DIR__ . '/vendor/autoload.php';

use \Firebase\JWT\JWT;

$key = "secret";
$payload = array(
    "iss" => "http://localhost",
    "user_id" => $row['user_id']
);

$jwt = JWT::encode($payload, $key, 'HS256');

$array = array(
    "jwt" => $jwt
);

$jsonData = json_encode($array);
header('Content-type: application/json');
echo $jsonData;
exit();
