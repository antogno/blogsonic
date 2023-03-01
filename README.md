# Blogsonic

<p>
    <a href="https://github.com/antogno/blogsonic/blob/master/LICENSE"><img src="https://img.shields.io/github/license/antogno/blogsonic" alt="License"></a>
    <a href="https://github.com/antogno/blogsonic/commits"><img src="https://img.shields.io/github/last-commit/antogno/blogsonic" alt="Last commit"></a>
    <a href="https://github.com/antogno/blogsonic/releases/latest"><img src="https://img.shields.io/github/v/tag/antogno/blogsonic?label=last%20release" alt="Last release"></a>
</p>

Blogsonic is a simple CRUD Web Application in PHP.

<p align="center">
	<img alt="Blogsonic screenshot" src="https://raw.githubusercontent.com/antogno/blogsonic/master/public/img/blogsonic-screenshot.png" style="border-radius: 5px; box-shadow: rgba(0, 0, 0, 0.09) 0 3px 12px;">
</p>

---

## Table of contents

- [What is Blogsonic?](#what-is-blogsonic)
- [Installation](#installation)
- [Running the acceptance tests](#running-the-acceptance-tests)
- [License](#license)
- [Links](#links)

## What is Blogsonic?

Blogsonic is an open source project. More specifically, is a CRUD Web Application. It could be defined as a mini Social Network that allows you to post text content (called Blogs) visible to all.

> **Note**: The existence of Blogsonic has the sole purpose of showing a very basic example of a CRUD Web Application. This means that not much attention has been paid to the general appereance of the website and to the code and its structure. Therefore, Blogsonic **should not** be used as a reference point in these respects, but should be considered as a starting point for beginners from which to start understanding the basic concepts.

### How was Blogsonic created?

Blogsonic was created using the following tools and technologies:

- Front-end:
  - HTML;
  - CSS (framework: Bootstrap);
  - JavaScript;
  - jQuery;
  - AJAX.
- Back-end:
  - PHP (framework: CodeIgniter 3.1.11);
  - MySQL.

Blogsonic also exists thanks to:

- [Font Awesome 4.7.0 icons][1];
- [Bootswatch Spacelab theme][2];
- [Codeception][3];
- [realfavicongenerator.net][4].

### Who created Blogsonic?

The designer and creator of Blogsonic it's me, that is Antonio Granaldi. You can see my LinkedIn profile by [clicking here][5].

### How can I contact you?

You can contact me on my LinkedIn profile above, or by sending an email to [tonio.granaldi@gmail.com](mailto:tonio.granaldi@gmail.com).

### Can I use the Blogsonic source code?

Of course! You can find everything you need on [GitHub][6].

## Installation

Follow the next steps to set up Blogsonic.

### Set up database

Create a database and add the following tables. You can also find these tables in `application/tables/`.

```sql
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
```

```sql
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
```

```sql
CREATE TABLE IF NOT EXISTS `sessions` (
    `id` varchar(128) NOT NULL,
    `ip_address` varchar(45) NOT NULL,
    `timestamp` int(10) unsigned DEFAULT 0 NOT NULL,
    `data` blob NOT NULL,
    KEY `sessions_timestamp` (`timestamp`)
);
```

### Create the `.env` file

Copy the `.env.example` file in the root of the project and name it `.env`.

```console
$ cp .env.example .env
```

The valid variables are:

- `CI_ENV`: defines the current environment. The available options are: `development`, `testing` and `production`. Setting the variable to a value of `development` will cause all PHP errors to be rendered to the browser when they occur. Conversely, setting the variable to `production` will disable all error output;
- `BLOGSONIC_BASE_URL`
- `BLOGSONIC_ENCRYPTION_KEY`: to generate an encryption key, you can go to [RandomKeygen][7] and scroll down to "CodeIgniter Encryption Keys";
- `BLOGSONIC_VERSION`: `HEAD` or a [valid GitHub tag][14];
- `BLOGSONIC_IN_EMAIL`: email address to be used publicly for contact purposes;
- `BLOGSONIC_OUT_EMAIL`: the outgoing email (e.g.: sending the forgotten password email);
- `BLOGSONIC_OUT_EMAIL_SMTP_PORT`
- `BLOGSONIC_OUT_EMAIL_SMTP_HOST`
- `BLOGSONIC_OUT_EMAIL_SMTP_USER`
- `BLOGSONIC_OUT_EMAIL_SMTP_PASS`
- `DB_HOST`
- `DB_USER`
- `DB_PASS`
- `DB_NAME`

## Running the acceptance tests

If you want to, you can also run the acceptance tests made with [Codeception][3]. To do this, follow the next steps.

> **Note**: If you decide to run the acceptance tests before actually using Blogsonic, you can skip the previous [tables creation](#set-up-database) step.

### Install Google Chrome and ChromeDriver

Install Google Chrome and check its version.

```console
$ google-chrome --version
```

Go to the [ChromeDriver website][9] and check which ChromeDriver version is the closest to your Google Chrome version.

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

For more information, see the official [Codeception documentation][10].

## License

Blogsonic is licensed under the terms of the [Creative Commons Zero v1.0 Universal license][11].

For more information, see the [Creative Commons website][12].

## Links

- [GitHub][6]
- [LinkedIn][5]
- [Twitter][13]

[1]: https://fontawesome.com/v4.7/ "Font Awesome - The iconic font and CSS toolkit"
[2]: https://bootswatch.com/spacelab/ "Bootswatch - Free themes for Bootstrap"
[3]: https://codeception.com/ "Codeception - PHP testing framework"
[4]: https://realfavicongenerator.net/ "Favicon Generator"
[5]: https://www.linkedin.com/in/antonio-granaldi/ "Antonio Granaldi - Linkedin"
[6]: https://github.com/antogno/blogsonic "Blogsonic - GitHub"
[7]: https://randomkeygen.com/#ci_key "RandomKeygen"
[8]: https://myaccount.google.com/lesssecureapps "Less secure apps - Google Accounts"
[9]: https://chromedriver.chromium.org/downloads "ChromeDriver - WebDriver for Chrome"
[10]: https://codeception.com/docs/modules/Db "Documentation - Codeception"
[11]: https://github.com/antogno/blogsonic/blob/master/LICENSE "License"
[12]: https://creativecommons.org/publicdomain/zero/1.0/ "Creative Commons"
[13]: https://twitter.com/AGranaldi "AGranaldi - Twitter"
[14]: https://github.com/antogno/blogsonic/ "Tags"
