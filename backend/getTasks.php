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

$mysql = new mysqli('localhost', 'root', '', 'dailytasks');

if ($mysql->connect_error) {
  die('Connection failed: '. $mysql->connect_error);
}

$sql = 'SELECT * FROM tasks WHERE user_id = '.$authData["user_id"];
$result = $mysql->query($sql);


$tasks = array();

while ($row = $result->fetch_assoc()) {
  $tasks[] = array(
    "task_id" => $row['task_id'],
    "task_content" => $row['task_content'],
    "isDone" => $row['isDone']
  );
}

$array = array(
  "tasks" => $tasks
);

$jsonData = json_encode($array);
header("Content-type: application/json");
echo $jsonData;
exit();