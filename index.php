<?php

require_once 'src/controller/TaskController.php';

header("Content-Type: application/json");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

$uri = explode("?", $uri)[0];

$baseUri = '/cursosphp/projetos-solo/to-do-api/';

$routes = [
  'GET ' . $baseUri . 'tasks' => 'TaskController@index',
  'GET ' . $baseUri . 'tasks/{id}' => 'TaskController@show',
  'POST ' . $baseUri . 'tasks' => 'TaskController@store',
  'PUT ' . $baseUri . 'tasks/{id}' => 'TaskController@update',
  'DELETE ' . $baseUri . 'tasks/{id}' => 'TaskController@destroy'
];

$controllerAction = null;

foreach ($routes as $route => $action) {
  list($routeMethod, $routeUri) = explode(' ', $route); //GET, /tasks
  $pattern = str_replace('{id}', '(\d+)', str_replace('/', '\/', $routeUri));

  if ($method == $routeMethod && preg_match("/^$pattern$/", $uri, $matches)) {
    $controllerAction = $action;
    break;
  }
}

if (!$controllerAction) {
  http_response_code(404);
  echo json_encode(['error' => 'Rota não encontrada!']);
  exit;
}

list($controllerName, $action) = explode('@', $controllerAction);
$controllerName = 'src\\controller\\' . $controllerName;
$controller = new $controllerName();
$controller->$action(isset($matches[1]) ? $matches[1] : null);
