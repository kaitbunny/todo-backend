<?php

namespace src\service;

require_once 'src/repository/TaskRepository.php';
require_once 'src/model/Task.php';

use Exception;
use InvalidArgumentException;
use PDO;
use src\model\Task;
use src\repository\TaskRepository;

class TaskService implements TaskRepository
{
  private PDO $pdo;

  public function __construct()
  {
    require_once __DIR__ . '/../../config.php';
    $this->pdo = $pdo;
  }

  public function findAll(): array
  {
    $tasks = [
      'items' => 0,
      'tasks' => []
    ];

    $sql = $this->pdo->query("SELECT * FROM tasks");

    $tasks['items'] = $sql->rowCount();
    if ($tasks['items'] > 0) {
      $data = $sql->fetchAll(PDO::FETCH_ASSOC);

      foreach ($data as $item) {
        $task = new Task();
        $task->setId($item['id']);
        $task->setTitle($item['title']);
        $task->setBody($item['body']);
        $task->setCreateDate($item['create_date']);
        $task->setTaskStatus($item['task_status']);

        $tasks['tasks'][] = $task->jsonSerializeDTO();
      }
    }

    return $tasks;
  }

  public function findById(int $id): Task
  {
    $sql = $this->pdo->prepare("SELECT * FROM tasks WHERE id = :id");
    $sql->bindValue(':id', $id);
    $sql->execute();

    if ($sql->rowCount() == 1) {
      $data = $sql->fetch();

      $task = new Task();
      $task->setId($data['id']);
      $task->setTitle($data['title']);
      $task->setBody($data['body']);
      $task->setCreateDate($data['create_date']);
      $task->setTaskStatus($data['task_status']);

      return $task;
    } else {
      header('HTTP/1.1 404 Not Found');
      throw new InvalidArgumentException("No items with the id: $id");
    }

    return new Task();
  }

  public function save(array $data): Task
  {
    try {
      $task = new Task();
      $task->setByJson($data);

      $this->pdo->beginTransaction();

      $sql = $this->pdo->prepare("INSERT INTO tasks(title, body, create_date, task_status) VALUES(:title, :body, :createDate, :taskStatus)");

      $sql->bindValue(':title', $task->getTitle());
      $sql->bindValue(':body', $task->getBody());
      $sql->bindValue(':createDate', $task->getCreateDate());
      $sql->bindValue(':taskStatus', $task->getTaskStatus());

      $sql->execute();

      if ($sql->rowCount() == 1) {
        $id = $this->pdo->lastInsertId();
        $task->setId($id);

        $this->pdo->commit();

        header('HTTP/1.1 201 Created');
        return $task;
      } else {
        $this->pdo->rollBack();
        throw new Exception();
      }
    } catch (InvalidArgumentException $e) {
      header('HTTP/1.1 400 Bad Request');
      throw new InvalidArgumentException('Invalid json. The json must contain title(string), body(string) and taskStatus(bool)');
    } catch (Exception $e) {
      header('HTTP/1.1 500 Internal Server Error');
      throw new Exception('Something went wrong');
    }
  }

  public function update(int $id, array $data): void
  {
    try {
      $newTask = new Task();
      $newTask->setByJson($data);
      $newTask->setId($id);

      $this->pdo->beginTransaction();

      $sql = $this->pdo->prepare("UPDATE tasks SET title = :title, body = :body, task_status = :taskStatus WHERE id = :id");

      $sql->bindValue(':title', $newTask->getTitle());
      $sql->bindValue(':body', $newTask->getBody());
      $sql->bindValue(':taskStatus', $newTask->getTaskStatus());
      $sql->bindValue(':id', $newTask->getId());

      $sql->execute();
      if ($sql->rowCount() == 1) {
        $this->pdo->commit();

        header('HTTP/1.1 200 OK');
        exit;
      } else {
        $this->pdo->rollBack();
        throw new Exception();
      }
    } catch (InvalidArgumentException $e) {
      header('HTTP/1.1 400 Bad Request');
      throw new InvalidArgumentException('Invalid json. The json must contain title(string), body(string) and taskStatus(bool)');
    } catch (Exception $e) {
      header('HTTP/1.1 404 Not Fount');
      throw new Exception("No items with the id: $id");
    }
  }

  public function delete(int $id): void
  {
    $this->pdo->beginTransaction();

    $sql = $this->pdo->prepare("DELETE FROM tasks WHERE id = :id");
    $sql->bindValue(':id', $id);
    $sql->execute();

    if ($sql->rowCount() == 1) {
      header('HTTP/1.1 204 No Content');
      $this->pdo->commit();
    } else {
      header('HTTP/1.1 404 Not Found');
      $this->pdo->rollBack();
    }
  }
}
