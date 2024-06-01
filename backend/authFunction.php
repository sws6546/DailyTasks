<?php
require_once __DIR__ . '/vendor/autoload.php';

use \Firebase\JWT\JWT;
use Firebase\JWT\Key;

function checkAuth($jwt)
{
  $key = "secret";

  try {
    $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
    $array = array(
      "ok" => true,
      "user_id" => $decoded->user_id
    );
    return $array;
  } catch (Exception $e) {
    $array = array(
      "ok" => false,
      "err" => "bad jwt"
    );
    return $array;
  }
}