<?php

$dbname = 'todo_api';
$dbhost = 'localhost';
$dbusername = 'root';
$dbpassword = '';

try {
  $pdo = new PDO("mysql:dbname=$dbname;host=$dbhost", $dbusername, $dbpassword);
} catch (PDOException $e) {
  $response = [
    'error' => '',
    'message' => ''
  ];

  $response['error'] = 'Error with the database connection';
  $response['message'] = $e->getMessage();

  echo json_encode($response);
  exit;
}
