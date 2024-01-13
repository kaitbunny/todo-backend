<?php

namespace src\repository;

use src\model\Task;

interface TaskRepository
{
  public function findAll(): array;
  public function findById(int $id): Task;
  public function save(array $data): Task;
  public function update(int $id, array $data): void;
  public function delete(int $id): void;
}
