<h1>
    <p align="center">
        <b><a href="https://www.blogsonic.org/">Blogsonic</a> - Simple CRUD Web Application in PHP</b>
    </p>
    <p align="center">
        <a href="https://www.php.net/"><img src="https://img.shields.io/badge/made%20with-PHP-787cb5?&amp;logo=php" alt="Made with PHP"></a>
        <a href="https://codeigniter.com/"><img src="https://img.shields.io/badge/made%20with-CodeIgniter%203.1.11-dd4814?&amp;logo=codeigniter" alt="Made with CodeIgniter 3.1.11"></a>
        <a href="https://www.blogsonic.org/LICENSE"><img src="https://img.shields.io/badge/license-CC--0-05b5da.svg" alt="License"></a>
        <a href="https://www.blogsonic.org/"><img src="https://img.shields.io/website-up-down-green-red/http/blogsonic.org.svg" alt="Blogsonic.org"></a>
        <a href="https://github.com/antogno/blogsonic"><img src="https://img.shields.io/badge/maintained-yes-green.svg" alt="Maintenance"></a>
    </p>
</h1>

<p>
    <img align="center" src="https://www.blogsonic.org/public/img/blogsonic-screenshot.png" alt="Blogsonic">
</p>

## Table of content

- **[What is Blogsonic?](#what-is-blogsonic)**
    - [How was Blogsonic created?](#how-was-blogsonic-created)
    - [Who created Blogsonic?](#who-created-blogsonic)
    - [How can I contact you?](#how-can-i-contact-you)
    - [Can I use the Blogsonic source code?](#can-i-use-the-blogsonic-source-code)
- **[Installation](#installation)**
    - [Set up database](#set-up-database)
    - [Add your base URL and an encryption key in the application/config/config.php file](#add-your-base-url-and-an-encryption-key-in-the-applicationconfigconfigphp-file)
    - [Add your email information in the application/core/MY_Controller.php file](#add-your-email-information-in-the-applicationcoremy_controllerphp-file)
    - [Edit the robots.txt and sitemap.xml files according to your data](#edit-the-robotstxt-and-sitemapxml-files-according-to-your-data)
    - [Set your domain in the Twitter meta tag in the application/views/partials/header.php file](#set-your-domain-in-the-twitter-meta-tag-in-the-applicationviewspartialsheaderphp-file)
    - [Set the current environment in the .htaccess file](#set-the-current-environment-in-the-htaccess-file)
- **[Running the acceptance tests](#running-the-acceptance-tests)**
    - [Install Google Chrome and ChromeDriver](#install-google-chrome-and-chromedriver)
    - [Install the Composer packages](#install-the-composer-packages)
    - [Add your base URL and the database's information in the tests/acceptance.suite.yml file](#add-your-base-url-and-the-databases-information-in-the-testsacceptancesuiteyml-file)
    - [Start ChromeDriver](#start-chromedriver)
    - [Run the acceptance tests](#run-the-acceptance-tests)
- **[License](#license)**
- **[Links](#links)**

---

## What is [Blogsonic](https://www.blogsonic.org/)?

[Blogsonic](https://www.blogsonic.org/) is an open source project. More specifically, is a CRUD Web Application. It could be defined as a mini Social Network that allows you to post text content (called Blogs) visible to all.

### How was [Blogsonic](https://www.blogsonic.org/) created?

Blogsonic was created using the following tools and technologies:

* Front-end:
    * HTML;
    * CSS (framework: Bootstrap);
    * JavaScript;
    * jQuery.
* Back-end:
    * PHP (framework: CodeIgniter 3.1.11);
    * MySQL.

### Who created [Blogsonic](https://www.blogsonic.org/)?

The designer and creator of [Blogsonic](https://www.blogsonic.org/) it's me, that is Antonio Granaldi. You can see my LinkedIn profile by [clicking here](https://www.linkedin.com/in/antonio-granaldi/).

### How can I contact you?

You can contact me on my LinkedIn profile above, or by sending an email to [tonio.granaldi@gmail.com](mailto:tonio.granaldi@gmail.com).

### Can I use the [Blogsonic](https://www.blogsonic.org/) source code?

Of course! You can find everything you need on [GitHub](https://github.com/antogno/blogsonic).

---

## Installation

Follow the next steps to set up Blogsonic.

### Set up database

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

2. Add the database's information in the `application/config/database.php` file.

    ```php
    $db['default'] = array(
        'hostname' => '', // Hostname (e.g.: localhost)
        'username' => '', // Database username (e.g.: root)
        'password' => '', // Password
        'database' => '' // Database name (e.g.: blogsonic)
    );
    ```

### Add your base URL and an encryption key in the `application/config/config.php` file

```php
$config['base_url'] = ''; // Base URL (e.g.: http://localhost/blogsonic/)

$config['encryption_key'] = ''; // Encryption key (e.g.: F7z4zM0L3ua6e9rdZgy0StgIYA8xIFai)
```

To generate an encryption key, you can go to [RandomKeygen](https://randomkeygen.com/) and scroll down to "CodeIgniter Encryption Keys".

### Add your email information in the `application/core/MY_Controller.php` file

This email will be used to send a new password to a user who has forgotten it. If you use Gmail, Google may block the automatic sending of the email. To turn this off, login to your Google account and enable the option "Allow less secure apps", [by clicking here](https://myaccount.google.com/lesssecureapps).

```php
$config['smtp_host'] = ''; // SMTP host (e.g.: ssl://smtp.googlemail.com)
$config['smtp_user'] = ''; // User (e.g.: example@gmail.com)
$config['smtp_pass'] = ''; // Password

$this->email->from('', 'Blogsonic.org'); // Email (e.g.: example@gmail.com)
```

> **Note**: This step is optional. Obviously, not doing this means not making the "Forgot password" feature work.

### Edit the `robots.txt` and `sitemap.xml` files according to your data

`sitemap.xml`:

```xml
<url>
    <loc>http://localhost/blogsonic/</loc> <!-- Page URL -->
    <lastmod>2021-10-02</lastmod> <!-- Last update -->
    <changefreq>always</changefreq>
    <priority>1.0</priority>
</url>
```

`robots.txt`:

```txt
User-agent: *
Disallow: /tests/

# URL to the sitemap.xml
Sitemap: http://localhost/blogsonic/sitemap.xml
```

> **Note**: This step is optional. These files are only used for the purpose of improving SEO Positioning.

For more information, see the [Sitemap protocol website](https://www.sitemaps.org/) and the official [Google documentation](https://developers.google.com/search/docs/advanced/robots/create-robots-txt).

### Set your domain in the Twitter meta tag in the `application/views/partials/header.php` file

```html
<meta property="twitter:domain" content="blogsonic.org"> <!-- Domain -->
```

### Set the current environment in the `.htaccess` file

```apache
SetEnv CI_ENV development
```

The available options are: `development`, `testing` and `production`. Setting the constant to a value of `development` will cause all PHP errors to be rendered to the browser when they occur. Conversely, setting the constant to `production` will disable all error output.

---

## Running the acceptance tests

If you want to, you can also run the acceptance tests made with [Codeception](https://codeception.com/). To do this, follow the next steps.

> **Note**: If you decide to run the acceptance tests before actually using Blogsonic, you can skip the previous [tables creation](#set-up-database) step.

### Install Google Chrome and ChromeDriver

Install Google Chrome and check its version.

```console
$ google-chrome --version
```

Go to the [ChromeDriver website](https://chromedriver.chromium.org/downloads) and check which ChromeDriver version is the closest to your Google Chrome version.

Then:

```console
$ wget https://chromedriver.storage.googleapis.com/<version>/chromedriver_linux64.zip
```

```console
$ unzip chromedriver_linux64.zip
```

```console
# mv chromedriver /usr/bin/chromedriver
```

### Install the Composer packages

From the `blogsonic/` folder, run the following command:

```console
$ bin/composer install
```

### Add your base URL and the database's information in the `tests/acceptance.suite.yml` file

```yml
actor: AcceptanceTester
modules:
    enabled:
        - WebDriver:
            url: # Base URL (e.g.: http://localhost/blogsonic)
        - Db:
            dsn: '' # PDO DSN (eg.: mysql:host=localhost)
            user: '' # Database username (e.g.: root)
            dbname: '' # Database name (e.g.: blogsonic)
            password: '' # Password
            initial_queries:
                - 'CREATE DATABASE IF NOT EXISTS ;' # Add the database name (e.g.: CREATE DATABASE IF NOT EXISTS blogsonic;)
                - 'USE ;' # Add the database name (e.g.: USE blogsonic;)
```

> **Note**: This configuration will only work with MySQL. If you need to change it, see the official [Codeception documentation](https://codeception.com/docs/modules/Db).

### Start ChromeDriver

```console
$ chromedriver --url-base=/wd/hub
```

### Run the acceptance tests

```console
$ vendor/bin/codecept run
```

You can also use the following command if you want to see all the single steps.

```console
$ vendor/bin/codecept run --steps
```

> **Note**: Running the acceptance tests will empty all the tables.

All tests are independent of each other. This means that you can run a single test (or a single suite) individually.

To run a single suite (found in the `tests/acceptance/` folder), use:

```console
$ vendor/bin/codecept run acceptance <name of the suite>
```

To run a single test from a suite, use:

```console
$ vendor/bin/codecept run acceptance <name of the suite>::<name of the test>
```

For example:

```console
$ vendor/bin/codecept run acceptance ProfilesCest
```

```console
$ vendor/bin/codecept run acceptance ProfilesCest::register
```

For more information, see the official [Codeception documentation](https://codeception.com/docs/01-Introduction).

---

## License

[Blogsonic](https://www.blogsonic.org/) is licensed under the terms of the [Creative Commons Zero v1.0 Universal license](https://www.blogsonic.org/LICENSE).

---

## Links

* **[Blogsonic.org](https://www.blogsonic.org/)**
* [GitHub](https://github.com/antogno/blogsonic)
* [LinkedIn](https://www.linkedin.com/in/antonio-granaldi/)
* [Facebook](https://www.facebook.com/antonio.granaldi)
* [Twitter](https://twitter.com/AGranaldi)
* [Reddit](https://www.reddit.com/user/antogno)
* [Stack Overflow](https://stackoverflow.com/users/16877786/antogno)