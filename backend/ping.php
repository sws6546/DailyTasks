<?php

require_once("cors.php");

$array = array(
    "response" => "pong"
);

$jsonData = json_encode($array);

header('Content-type: application/json');
echo $jsonData;