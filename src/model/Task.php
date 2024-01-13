<?php

namespace src\model;

use DateTime;
use Exception;
use InvalidArgumentException;
use JsonSerializable;

class Task implements JsonSerializable
{
  private int $id;
  private string $title;
  private string $body;
  private DateTime $createDate;
  private bool $taskStatus;

  public function __construct()
  {
  }

  public function setByJson(array $data): void
  {
    try {
      $title = $data['title'] ?? null;
      $body = $data['body'] ?? null;
      $taskStatus = $data['taskStatus'] ?? null;

      if ($title === null || $body === null || $taskStatus === null) {
        throw new Exception();
      }

      self::setTitle($title);
      self::setBody($body);
      self::setCreateDateToToday();
      self::setTaskStatus($taskStatus);
    } catch (Exception $e) {
      throw new InvalidArgumentException('invalid array');
    }
  }

  public function getId(): int
  {
    return $this->id;
  }

  public function setId(int $id): void
  {
    if (is_integer($id) && $id > 0) {
      $this->id = $id;
    }
  }

  public function getTitle(): string
  {
    return $this->title;
  }

  public function setTitle(string $title): void
  {
    if (strlen(str_replace(' ', '', $title)) >= 2) {
      $title = ucfirst(trim($title));
      $this->title = $title;
    } else {
      throw new InvalidArgumentException('The title size must be greater or equal to 2 letters');
    }
  }

  public function getBody(): string
  {
    return $this->body;
  }

  public function setBody(string $body): void
  {
    if (strlen(str_replace(' ', '', $body)) >= 2) {
      $body = ucfirst(trim($body));
      $this->body = $body;
    } else {
      throw new InvalidArgumentException('The body size must be greater or equal to 2 letters');
    }
  }

  public function getCreateDate(): string
  {
    return $this->createDate->format('Y-m-d');
  }

  public function setCreateDate(string $date): void
  {
    $this->createDate = DateTime::createFromFormat('Y-m-d', $date);

    if ($this->createDate === false) {
      throw new InvalidArgumentException('Invalid date format. Expected format: Y-m-d');
    }
  }

  public function setCreateDateToToday(): void
  {
    $this->createDate = new DateTime();
  }

  public function getTaskStatus(): bool
  {
    return $this->taskStatus;
  }

  public function setTaskStatus(bool $taskStatus): void
  {
    $this->taskStatus = $taskStatus;
  }

  public function jsonSerialize(): array
  {
    return [
      'id' => self::getId(),
      'title' => self::getTitle(),
      'body' => self::getBody(),
      'createDate' => self::getCreateDate(),
      'taskStatus' => self::getTaskStatus(),
    ];
  }

  public function jsonSerializeDTO(): array
  {
    return [
      'id' => self::getId(),
      'title' => self::getTitle(),
      'createDate' => self::getCreateDate(),
      'taskStatus' => self::getTaskStatus(),
    ];
  }
}
