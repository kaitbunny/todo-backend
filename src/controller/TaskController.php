<?php

namespace src\controller;

require_once 'src/service/TaskService.php';

use Exception;
use src\service\TaskService;

class TaskController
{
  private $taskService;

  public function __construct()
  {
    $this->taskService = new TaskService();
  }

  public function index()
  {
    $array = $this->taskService->findAll();
    echo json_encode($array);
  }

  public function show(int $id)
  {
    try {
      $response = $this->taskService->findById($id);
      echo json_encode($response);
    } catch (Exception $e) {
      echo json_encode(['error' => $e->getMessage()]);
    }
  }

  public function store()
  {
    try {
      $postJson = json_decode(file_get_contents('php://input'), true);

      $response = $this->taskService->save($postJson);

      echo json_encode($response);
    } catch (Exception $e) {
      echo json_encode(['error' => $e->getMessage()]);
    }
  }

  public function update(int $id)
  {
    try {
      $postJson = json_decode(file_get_contents('php://input'), true);

      $response = $this->taskService->update($id, $postJson);

      echo json_encode($response);
    } catch (Exception $e) {
      echo json_encode(['error' => $e->getMessage()]);
    }
  }

  public function destroy(int $id)
  {
    $this->taskService->delete($id);
  }
}
