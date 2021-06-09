CREATE TABLE `blogs` (
    `id` int NOT NULL AUTO_INCREMENT,
    `user_id` int NOT NULL,
    `title` varchar(20) NOT NULL,
    `body` text NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_usersblogs` FOREIGN KEY (`user_id`)
    REFERENCES `users`(`id`)
    ON UPDATE CASCADE
    ON DELETE CASCADE
);