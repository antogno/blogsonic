<!DOCTYPE html>
<html>
<head>
    <title><?= $title; ?> | Blogsonic</title>
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('public/assets/icon/apple-touch-icon.png'); ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('public/assets/icon/favicon-32x32.png'); ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('public/assets/icon/favicon-16x16.png'); ?>">
    <link rel="manifest" href="<?= base_url('public/assets/icon/site.webmanifest'); ?>">
    <link rel="mask-icon" href="<?= base_url('public/assets/icon/safari-pinned-tab.svg'); ?>" color="#5bbad5">
    <link rel="shortcut icon" href="<?= base_url('public/assets/icon/favicon.ico'); ?>">
    <meta name="msapplication-TileColor" content="#426e9c">
    <meta name="msapplication-config" content="<?= base_url('public/assets/icon/browserconfig.xml'); ?>">
    <meta name="theme-color" content="#ffffff">
    <script src="<?= base_url('public/assets/jquery/jquery.min.js'); ?>"></script>
    <link rel="stylesheet" href="<?= base_url('public/assets/css/bootstrap.min.css'); ?>"/>
    <link rel="stylesheet" href="<?= base_url('public/assets/css/style.css'); ?>"/>
    <link rel="stylesheet" href="<?= base_url('public/assets/font-awesome-4.7.0/css/font-awesome.min.css'); ?>"/>
    <script src="<?= base_url('public/assets/js/bootstrap.bundle.min.js'); ?>" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</head>
<body>
    <div class="modal" id="cookiebar">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?= $this->lang->line('cookiebar_title'); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"></span>
                </button>
            </div>
            <div class="modal-body">
                <p><?= $this->lang->line('cookiebar_body'); ?>
                <a href="<?= base_url($this->session->userdata('language') . 'pages/view/privacy'); ?>"><?= $this->lang->line('privacy_policy_link'); ?></a>.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="cookiebar_hide"><?= $this->lang->line('cookiebar_accept'); ?></button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= $this->lang->line('cookiebar_close'); ?></button>
            </div>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand col-3 col-sm-3 col-md-2 col-lg-1 col-xl-1" href="<?= base_url($this->session->userdata('language')); ?>"><img src="<?= base_url('public/assets/img/blogsonic-logo-min.png'); ?>" class="img-fluid" alt="Blogsonic"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarColor01">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url($this->session->userdata('language') . 'pages/view/home'); ?>"><?= $this->lang->line('home_nav'); ?>
                            <span class="visually-hidden"></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url($this->session->userdata('language') . 'pages/view/about'); ?>"><?= $this->lang->line('about_nav'); ?></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><?= $this->lang->line('profiles_nav'); ?></a>
                        <div class="dropdown-menu toggle">
                            <?php
                                if($this->session->userdata('logged_in')) {
                            ?>
                            <a class="dropdown-item" href="<?= base_url($this->session->userdata('language') . 'profiles'); ?>"><?= $this->lang->line('myprofile_nav'); ?></a>
                            <div class="dropdown-divider"></div>
                            <?php
                                }
                            ?>
                            <?php
                                if(!$this->session->userdata('logged_in')) {
                            ?>
                            <a class="dropdown-item" href="<?= base_url($this->session->userdata('language') . 'profiles/login'); ?>"><?= $this->lang->line('login_nav'); ?></a>
                            <?php
                                } else {
                            ?>
                            <a onclick="return confirmation()" class="dropdown-item" href="<?= base_url($this->session->userdata('language') . 'profiles/logout'); ?>"><?= $this->lang->line('logout_nav'); ?></a>
                            <?php
                                }
                            ?>
                            <a class="dropdown-item" href="<?= base_url($this->session->userdata('language') . 'profiles/register'); ?>"><?= $this->lang->line('register_nav'); ?></a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><?= $this->lang->line('blogs_nav'); ?></a>
                        <div class="dropdown-menu toggle">
                            <a class="dropdown-item" href="<?= base_url($this->session->userdata('language') . 'blogs/all'); ?>"><?= $this->lang->line('allblogs_nav'); ?></a>
                            <?php
                                if($this->session->userdata('logged_in')) {
                            ?>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?= base_url($this->session->userdata('language') . 'blogs/myblogs'); ?>"><?= $this->lang->line('myblogs_nav'); ?></a>
                            <a class="dropdown-item" href="<?= base_url($this->session->userdata('language') . 'blogs/newblog'); ?>"><?= $this->lang->line('newblog_nav'); ?></a>
                            <?php
                                }
                            ?>
                        </div>
                    </li>
                </ul>
                <ul class="navbar-nav mr-auto d-flex">
                    <li>
                        <a class="nav-link" target="_blank" href="https://www.linkedin.com/in/antonio-granaldi/">
                            <i class="fa fa-linkedin-square" aria-hidden="true"></i>&nbsp;LinkedIn
                            <span class="visually-hidden"></span>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" target="_blank" href="https://github.com/">
                            <i class="fa fa-github" aria-hidden="true"></i>&nbsp;GitHub
                            <span class="visually-hidden"></span>
                        </a>
                    </li>
                </ul>
                <!-- <form class="d-flex">
                    <input class="form-control me-sm-2" type="text" placeholder="<?= $this->lang->line('search'); ?>">
                    <button class="btn btn-secondary my-2 my-sm-0" type="submit"><?= $this->lang->line('search'); ?></button>
                </form> -->
            </div>
        </div>
    </nav>
    <div>
        <h1 style="padding: 4.625rem 0 0 1rem"><?= $title; ?></h1>
    </div>
    <div style="padding: 0 1rem 0 1rem">