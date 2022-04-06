<!DOCTYPE html>
<html lang="<?= substr($this->encryption->decrypt($this->session->userdata('language')), 0, -1); ?>">
<head>
    <!-- Title and description -->
    <title><?php if (isset($meta_title)) { ?><?= $meta_title; ?><?php } else { ?><?= $title; ?><?php } ?></title>
    <?php if (isset($meta_description)) { ?> <meta name="description" content="<?= $meta_description; ?>"> <?php } ?>

    <!-- Theme color -->
    <meta name="theme-color" content="#446e9b">

    <!-- Viewport -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Keywords -->
    <meta name="keywords" content="blogsonic.org, blogsonic, blogs, open source, CRUD, CRUD web application, PHP, php website">

    <!-- Open Graph Meta Tags -->
    <meta property="og:url" content="<?= base_url(); ?>">
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?php if (isset($meta_title)) { ?><?= $meta_title; ?><?php } else { ?><?= $title; ?><?php } ?>">
    <?php if (isset($meta_description)) { ?> <meta property="og:description" content="<?= $meta_description; ?>"> <?php } ?>
    <meta property="og:image" content="<?= base_url('public/img/blogsonic-social-preview.png'); ?>">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1280">
    <meta property="og:image:height" content="640">

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta property="twitter:domain" content="blogsonic.org">
    <meta property="twitter:url" content="<?= base_url(); ?>">
    <meta name="twitter:title" content="<?php if (isset($meta_title)) { ?><?= $meta_title; ?><?php } else { ?><?= $title; ?><?php } ?>">
    <?php if (isset($meta_description)) { ?> <meta name="twitter:description" content="<?= $meta_description; ?>"> <?php } ?>
    <meta name="twitter:image" content="<?= base_url('public/img/blogsonic-social-preview.png'); ?>">

    <!-- Microsoft Meta Tags -->
    <meta name="msapplication-TileColor" content="#426e9c">
    <meta name="msapplication-config" content="<?= base_url('public/icon/browserconfig.xml'); ?>">    

    <!-- Icons -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('public/icon/apple-touch-icon.png'); ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('public/icon/favicon-32x32.png'); ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('public/icon/favicon-16x16.png'); ?>">
    <link rel="manifest" href="<?= base_url('public/icon/site.webmanifest'); ?>">
    <!-- <link rel="mask-icon" href="<?= base_url('public/icon/safari-pinned-tab.svg'); ?>" color="#5bbad5"> -->
    <link rel="shortcut icon" href="<?= base_url('favicon.ico'); ?>">

    <!-- Styles -->
    <link rel="stylesheet" href="<?= base_url('public/css/bootstrap.min.css'); ?>"/>
    <link rel="stylesheet" href="<?= base_url('public/lib/font-awesome-4.7.0/css/font-awesome.min.css'); ?>"/>

    <!-- JavaScript -->
    <script src="<?= base_url('public/lib/jquery/jquery.min.js'); ?>"></script>
    <script src="<?= base_url('public/js/bootstrap.bundle.min.js'); ?>"></script>
</head>
<body>
<!-- Cookie pop-up -->
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
                    <a href="<?= base_url($this->encryption->decrypt($this->session->userdata('language')) . 'pages/view/privacy'); ?>"><?= $this->lang->line('privacy_policy'); ?></a>.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="cookiebar_hide"><?= $this->lang->line('accept'); ?></button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= $this->lang->line('close'); ?></button>
            </div>
        </div>
    </div>
</div>
<!-- Header -->
<header>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= base_url($this->encryption->decrypt($this->session->userdata('language'))); ?>"><img src="<?= base_url('public/img/blogsonic-logo-min.png'); ?>" alt="Blogsonic" style="height: 30px;"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarColor01">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php if (strpos(current_url(), 'pages/view/home')) { echo 'active'; } ?>" href="<?= base_url($this->encryption->decrypt($this->session->userdata('language')) . 'pages/view/home'); ?>"><?= $this->lang->line('home'); ?>
                            <span class="visually-hidden"></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if (strpos(current_url(), 'pages/view/about')) { echo 'active'; } ?>" href="<?= base_url($this->encryption->decrypt($this->session->userdata('language')) . 'pages/view/about'); ?>"><?= $this->lang->line('about'); ?></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?php if ($this->router->fetch_class() == 'blogs') { echo 'active'; } ?>" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><?= $this->lang->line('blogs'); ?></a>
                        <div class="dropdown-menu toggle">
                            <a class="dropdown-item" href="<?= base_url($this->encryption->decrypt($this->session->userdata('language')) . 'blogs/all'); ?>"><?= $this->lang->line('all_blogs'); ?></a>
                            <?php
                                if ($this->session->userdata('logged_in')) {
                            ?>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?= base_url($this->encryption->decrypt($this->session->userdata('language')) . 'blogs/myblogs'); ?>"><?= $this->lang->line('my_blogs'); ?></a>
                            <a class="dropdown-item" href="<?= base_url($this->encryption->decrypt($this->session->userdata('language')) . 'blogs/newblog'); ?>"><?= $this->lang->line('new_blog'); ?></a>
                            <?php
                                }
                            ?>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?php if ($this->router->fetch_class() == 'profiles') { echo 'active'; } ?>" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                            <?php
                                if ($this->session->userdata('logged_in')) {
                                    echo '<i id="user_icon" class="fa fa-user" aria-hidden="true"></i> ' . $this->encryption->decrypt($this->session->userdata('username')) . '</span>';
                                } else {
                                    echo $this->lang->line('profile');
                                }
                            ?>
                        </a>
                        <div class="dropdown-menu toggle">
                            <?php
                                if ($this->session->userdata('logged_in')) {
                            ?>
                            <a class="dropdown-item" href="<?= base_url($this->encryption->decrypt($this->session->userdata('language')) . 'profiles'); ?>"><?= $this->lang->line('my_profile'); ?></a>
                            <div class="dropdown-divider"></div>
                            <?php
                                }
                            ?>
                            <?php
                                if ( ! $this->session->userdata('logged_in')) {
                            ?>
                            <a class="dropdown-item" href="<?= base_url($this->encryption->decrypt($this->session->userdata('language')) . 'profiles/login'); ?>" style="white-space: nowrap;"><i class="fa fa-sign-in" aria-hidden="true"></i> <?= $this->lang->line('login'); ?></a>
                            <?php
                                } else {
                            ?>
                            <a onclick="return confirmation()" class="dropdown-item" href="<?= base_url($this->encryption->decrypt($this->session->userdata('language')) . 'profiles/logout'); ?>"><i class="fa fa-sign-out" aria-hidden="true"></i> <?= $this->lang->line('logout'); ?></a>
                            <?php
                                }
                            ?>
                            <a class="dropdown-item" href="<?= base_url($this->encryption->decrypt($this->session->userdata('language')) . 'profiles/register'); ?>"><?= $this->lang->line('register'); ?></a>
                        </div>
                    </li>
                </ul>
                <ul class="navbar-nav mr-auto d-flex">
                    <li>
                        <a class="nav-link" target="_blank" href="https://www.linkedin.com/in/antonio-granaldi/" style="white-space: nowrap;">
                            <i class="fa fa-linkedin-square" aria-hidden="true"></i>&nbsp;<?= $this->lang->line('linkedin'); ?>
                            <span class="visually-hidden"></span>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" target="_blank" href="https://github.com/antogno/blogsonic" style="white-space: nowrap;">
                            <i class="fa fa-github" aria-hidden="true"></i>&nbsp;<?= $this->lang->line('github'); ?>
                            <span class="visually-hidden"></span>
                        </a>
                    </li>
                </ul>
                <form class="d-flex" action="<?= base_url($this->encryption->decrypt($this->session->userdata('language')) . 'blogs/all'); ?>" method="get">
                    <input class="form-control me-sm-2" type="text" placeholder="<?= $this->lang->line('search_placeholder'); ?>" id="search" name="search">
                    <button class="btn btn-secondary my-2 my-sm-0" type="submit"><?= $this->lang->line('search'); ?></button>
                </form>
            </div>
        </div>
    </nav>
</header>
<!-- Section -->
<section>
    <div>
        <h1 style="padding: 70px 0 0 20px"><?= $title; ?></h1>
    </div>
    <div style="padding: 0 20px 0 20px" id="page_body">