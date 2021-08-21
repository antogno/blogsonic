# What is [Blogsonic.org](https://www.blogsonic.org/)?

[Blogsonic.org](https://www.blogsonic.org/) is an open source project. More specifically, is a CRUD Web Application. It could be defined as a mini Social Network that allows you to post text content (called Blogs) visible to all.

## How was [Blogsonic.org](https://www.blogsonic.org/) created?

Blogsonic.org was created using the following tools and technologies:

* Front-end:
    * HTML;
    * CSS (framework: Bootstrap);
    * Javascript;
    * jQuery.
* Back-end:
    * PHP (framework: CodeIgniter 3.1.11);
    * MySQL.

## Who created [Blogsonic.org](https://www.blogsonic.org/)?

The designer and creator of [Blogsonic.org](https://www.blogsonic.org/) it's me, that is Antonio Granaldi. You can see my LinkedIn profile by [clicking here](https://www.linkedin.com/in/antonio-granaldi/).

## How can I contact you?

You can contact me on my LinkedIn profile above, or by sending an email to [tonio.granaldi@gmail.com](mailto:tonio.granaldi@gmail.com).

## Can I use the [Blogsonic.org](https://www.blogsonic.org/) source code?

Of course! You can find everything you need on [GitHub](https://github.com/antogno/blogsonic).

# Installation

Follow the next steps to set up Blogsonic.

## Set up database

1. Create a database and add the following tables.

    You can also find these tables in `application/tables/`.

    ~~~~sql
    CREATE TABLE `users` (
        `id` int NOT NULL AUTO_INCREMENT,
        `name` varchar(50) NOT NULL,
        `surname` varchar(50) NOT NULL,
        `gender` varchar(1) NOT NULL,
        `username` varchar(50) NOT NULL,
        `password` varchar(255) NOT NULL,
        `email` varchar(50) NOT NULL,
        `phone` varchar(13) NOT NULL,
        `language` varchar(2) NOT NULL,
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    );
    ~~~~

    ~~~~sql
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
    ~~~~

    ~~~~sql
    CREATE TABLE IF NOT EXISTS `ci_sessions` (
        `id` varchar(128) NOT NULL,
        `ip_address` varchar(45) NOT NULL,
        `timestamp` int(10) unsigned DEFAULT 0 NOT NULL,
        `data` blob NOT NULL,
        KEY `ci_sessions_timestamp` (`timestamp`)
    );
    ~~~~

2. Add the database's informations in the `application/config/database.php` file.

    ```php
    $db['default'] = array(
        'hostname' => '', // Hostame (e.g.: localhost)
        'username' => '', // Database username (e.g.: root)
        'password' => '', // Password
        'database' => '' // Database name (e.g.: blogsonic)
    );
    ```

## Add the base URL in the `application/config/config.php` file

```php
$config['base_url'] = ''; // Base URL (e.g.: http://localhost/blogsonic/)
```

## Add your email informations to MY_Controller::sendNewPassword found in `application/core/MY_Controller.php`

This email will be used to send a new password to a user who has forgotten it.

```php
$config['smtp_host'] = ''; // SMTP host (e.g.: ssl://smtp.googlemail.com)
$config['smtp_user'] = ''; // User (e.g.: example@gmail.com)
$config['smtp_pass'] = ''; // Password

$this->email->from('', 'Blogsonic.org'); // Email (e.g.: example@gmail.com)
```