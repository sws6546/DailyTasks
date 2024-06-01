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

if (empty($data)) {
  $array = array(
    "err" => "bad request, no data"
  );
  $jsonData = json_encode($array);
  header('Content-type: application/json');
  echo $jsonData;
  exit();
}

$jwt = $data['jwt'];

if (empty($jwt)) {
  $array = array(
    "err" => "bad request, no jwt"
  );
  $jsonData = json_encode($array);
  header('Content-type: application/json');
  echo $jsonData;
  exit();
}

require_once __DIR__ . '/vendor/autoload.php';

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

try {
  $decoded = JWT::decode($jwt, new Key('secret', 'HS256'));
  $decodedArray = (array) $decoded;
  $mysql = new mysqli('localhost', 'root', '', 'dailytasks');
  $result = $mysql->query("SELECT * FROM users WHERE user_id = '" . $decodedArray["user_id"] . "'");
  $username = $result->fetch_assoc()["login"];
  $array = array(
    "ok" => true,
    "user_id" => $decodedArray["user_id"],
    "username" => $username
  );
  $jsonData = json_encode($array);
  header('Content-type: application/json');
  echo $jsonData;
  exit();
} catch (\Exception $e) {
  $array = array(
    "err" => $e->getMessage()
  );
  $jsonData = json_encode($array);
  header('Content-type: application/json');
  echo $jsonData;
  exit();
}
