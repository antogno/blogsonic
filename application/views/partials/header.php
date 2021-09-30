<!DOCTYPE html>
<html>
<head>
    <title><?= $title; ?> | Blogsonic</title>
    <?php 
        if (isset($meta_description)) {
    ?>
        <meta name="description" content="<?= $meta_description; ?>">
    <?php
        }
    ?>
    <link rel="alternate" hreflang="it" href="<?= base_url('it'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:image" content="<?= base_url('public/img/blogsonic-social-preview.png'); ?>">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1280">
    <meta property="og:image:height" content="640">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('public/icon/apple-touch-icon.png'); ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('public/icon/favicon-32x32.png'); ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('public/icon/favicon-16x16.png'); ?>">
    <link rel="manifest" href="<?= base_url('public/icon/site.webmanifest'); ?>">
    <!-- <link rel="mask-icon" href="<?= base_url('public/icon/safari-pinned-tab.svg'); ?>" color="#5bbad5"> -->
    <link rel="shortcut icon" href="<?= base_url('favicon.ico'); ?>">
    <meta name="msapplication-TileColor" content="#426e9c">
    <meta name="msapplication-config" content="<?= base_url('public/icon/browserconfig.xml'); ?>">
    <meta name="theme-color" content="#ffffff">
    <script src="<?= base_url('public/jquery/jquery.min.js'); ?>"></script>
    <link rel="stylesheet" href="<?= base_url('public/css/bootstrap.min.css'); ?>"/>
    <link rel="stylesheet" href="<?= base_url('public/font-awesome-4.7.0/css/font-awesome.min.css'); ?>"/>
    <script src="<?= base_url('public/js/bootstrap.bundle.min.js'); ?>"></script>
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
                        <a href="<?= base_url($this->encryption->decrypt($this->session->userdata('language')) . 'pages/view/privacy'); ?>"><?= $this->lang->line('privacy_policy_link'); ?></a>.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="cookiebar_hide"><?= $this->lang->line('cookiebar_accept'); ?></button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= $this->lang->line('cookiebar_close'); ?></button>
                </div>
            </div>
        </div>
    </div>
    <!-- Header -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-primary">
            <div class="container-fluid">
                <a class="navbar-brand col-4 col-sm-3 col-md-2 col-lg-1 col-xl-1" href="<?= base_url($this->encryption->decrypt($this->session->userdata('language'))); ?>"><img src="<?= base_url('public/img/blogsonic-logo-min.png'); ?>" class="img-fluid" alt="Blogsonic"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarColor01">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link <?php if (strpos(current_url(), 'pages/view/home')) { echo 'active'; } ?>" href="<?= base_url($this->encryption->decrypt($this->session->userdata('language')) . 'pages/view/home'); ?>"><?= $this->lang->line('home_nav'); ?>
                                <span class="visually-hidden"></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if (strpos(current_url(), 'pages/view/about')) { echo 'active'; } ?>" href="<?= base_url($this->encryption->decrypt($this->session->userdata('language')) . 'pages/view/about'); ?>"><?= $this->lang->line('about_nav'); ?></a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle <?php if ($this->router->fetch_class() == 'profiles') { echo 'active'; } ?>" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><?= $this->lang->line('profiles_nav'); ?></a>
                            <div class="dropdown-menu toggle">
                                <?php
                                    if ($this->session->userdata('logged_in')) {
                                ?>
                                <a class="dropdown-item" href="<?= base_url($this->encryption->decrypt($this->session->userdata('language')) . 'profiles'); ?>"><?= $this->lang->line('myprofile_nav'); ?></a>
                                <div class="dropdown-divider"></div>
                                <?php
                                    }
                                ?>
                                <?php
                                    if ( ! $this->session->userdata('logged_in')) {
                                ?>
                                <a class="dropdown-item" href="<?= base_url($this->encryption->decrypt($this->session->userdata('language')) . 'profiles/login'); ?>"><?= $this->lang->line('login_nav'); ?></a>
                                <?php
                                    } else {
                                ?>
                                <a onclick="return confirmation()" class="dropdown-item" href="<?= base_url($this->encryption->decrypt($this->session->userdata('language')) . 'profiles/logout'); ?>"><?= $this->lang->line('logout_nav'); ?></a>
                                <?php
                                    }
                                ?>
                                <a class="dropdown-item" href="<?= base_url($this->encryption->decrypt($this->session->userdata('language')) . 'profiles/register'); ?>"><?= $this->lang->line('register_nav'); ?></a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle <?php if ($this->router->fetch_class() == 'blogs') { echo 'active'; } ?>" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><?= $this->lang->line('blogs_nav'); ?></a>
                            <div class="dropdown-menu toggle">
                                <a class="dropdown-item" href="<?= base_url($this->encryption->decrypt($this->session->userdata('language')) . 'blogs/all'); ?>"><?= $this->lang->line('allblogs_nav'); ?></a>
                                <?php
                                    if ($this->session->userdata('logged_in')) {
                                ?>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?= base_url($this->encryption->decrypt($this->session->userdata('language')) . 'blogs/myblogs'); ?>"><?= $this->lang->line('myblogs_nav'); ?></a>
                                <a class="dropdown-item" href="<?= base_url($this->encryption->decrypt($this->session->userdata('language')) . 'blogs/newblog'); ?>"><?= $this->lang->line('newblog_nav'); ?></a>
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
                            <a class="nav-link" target="_blank" href="https://github.com/antogno/blogsonic">
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
    </header>
    <div>
        <h1 style="padding: 4.625rem 0 0 1rem"><?= $title; ?></h1>
    </div>
    <div style="padding: 0 1rem 0 1rem" id="page_body">