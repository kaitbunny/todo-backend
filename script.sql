CREATE SCHEMA todo_api;
USE todo_api;

CREATE TABLE tasks (
	id BIGINT NOT NULL AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    body TEXT NOT NULL,
    create_date DATE NOT NULL,
    task_status TINYINT(1) NOT NULL DEFAULT 0,
    
    PRIMARY KEY(id)
)engine=InnoDB default charset=utf8mb4;