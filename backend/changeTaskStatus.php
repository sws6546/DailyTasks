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
$task_id = $data['task_id'];

if (empty($data)) {
  $array = array(
    "err" => "bad request, no data"
  );
  $jsonData = json_encode($array);
  header('Content-type: application/json');
  echo $jsonData;
  exit();
}

require_once ("authFunction.php");

$authData = checkAuth($jwt);

if (!$authData["ok"]) {
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
  die('Error : (' . $mysql->connect_errno . ') ' . $mysql->connect_error);
}

$task = $mysql->query("SELECT * FROM tasks WHERE task_id = '$task_id' AND user_id = '" . $authData["user_id"] . "'");

if ($task->num_rows == 0) {
  $array = array(
    "err" => "task not found"
  );
  $jsonData = json_encode($array);
  header('Content-type: application/json');
  echo $jsonData;
  exit();
}

$task = $task->fetch_assoc();

if ($task["isDone"] == 0) {
  $mysql->query("UPDATE tasks SET isDone = 1 WHERE task_id = '$task_id' AND user_id = '" . $authData["user_id"] . "'");
}
else {
  $mysql->query("UPDATE tasks SET isDone = 0 WHERE task_id = '$task_id' AND user_id = '" . $authData["user_id"] . "'");
}

$array = array(
  "ok" => true,
  "task_id" => $task_id
);
$jsonData = json_encode($array);
header('Content-type: application/json');
echo $jsonData;