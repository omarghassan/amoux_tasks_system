CREATE TABLE tasks (
	id int PRIMARY KEY AUTO_INCREMENT,
    user_id int,
    title varchar(191) NOT NULL,
    date DATE NOT NULL,
    priority ENUM('extreme', 'moderate', 'low'),
    task_status ENUM('completed', 'in_progress', 'not_started'),
    description MEDIUMTEXT,
    status TINYINT(1) DEFAULT 1 COMMENT '0=deleted, 1=active',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id)
)