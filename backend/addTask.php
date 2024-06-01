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

$taskContent = $data['taskContent'];

$jwt = $data['jwt'];

require_once("authFunction.php");
$authData = checkAuth($jwt);

if(!$authData["ok"]) {
  $array = array(
    "err" => "bad jwt"
  );
  $jsonData = json_encode($array);
  header('Content-type: application/json');
  echo $jsonData;
  exit();
}

if(empty($taskContent)) {
  $array = array(
    "err" => "bad request, no task content"
  );
  $jsonData = json_encode($array);
  header('Content-type: application/json');
  echo $jsonData;
  exit();
}

$mysql = new mysqli('localhost', 'root', '', 'dailytasks');

if ($mysql->connect_error) {
  $array = array(
    "err" => "Failed to connect to MySQL: " . $mysql->connect_error
  );
  $jsonData = json_encode($array);
  header('Content-type: application/json');
  echo $jsonData;
  exit();
}

$sql = "INSERT INTO tasks (user_id, task_content, isDone) VALUES ('".$authData["user_id"]."', '$taskContent', '0')";
$mysql->query($sql);

$array = array(
  "ok" => true
);
$jsonData = json_encode($array);
header('Content-type: application/json');
echo $jsonData;
exit();