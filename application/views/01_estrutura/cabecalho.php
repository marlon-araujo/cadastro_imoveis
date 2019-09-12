<?php
/**
 * Created by PhpStorm.
 * User: Marlon Araújo
 * Date: 04/04/2019
 * Time: 13:53
 */

$CI =& get_instance();
$CI->load->library('menu');
$menu = $CI->menu->buscar_menu($this->session->userdata[SS_USUARIO]['codigo_gru']);
$paginas = $CI->menu->buscar_paginas();

$nome = $this->session->userdata[SS_USUARIO]['login_usu'];
$array_nome = explode(' ', $nome);
$email = $this->session->userdata[SS_USUARIO]['login_usu'];
?>
<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Cadastro de Imóveis</title>
    <link rel="stylesheet" href="<?= base_url('assets/vendors/mdi/css/materialdesignicons.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendors/css/vendor.bundle.base.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="shortcut icon" href="<?= base_url('assets/images/favicon.png') ?>" />
    <?php
    if (!empty($css_link)) {
        foreach ($css_link as $cada) { ?>
            <link href="<?= $cada . V ?>" rel="stylesheet">
    <?php } }

    if (!empty($css)) {
        foreach ($css as $cada) { ?>
            <link href="<?= base_url($cada . V) ?>" rel="stylesheet">
    <?php } } ?>
  </head>
  <body>
    <div class="container-scroller">
      <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
          <a class="navbar-brand brand-logo" href="#"><img src="assets/images/logo.svg" alt="logo" /></a>
          <a class="navbar-brand brand-logo-mini" href="#"><img src="assets/images/logo-mini.svg" alt="logo" /></a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-stretch">
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
          </button>
          <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item nav-profile dropdown">
              <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                <div class="nav-profile-img">
                  <img src="assets/images/faces/face1.png" alt="image">
                  <span class="availability-status online"></span>
                </div>
                <div class="nav-profile-text">
                  <p class="mb-1 text-black"><?= $array_nome[0] ?></p>
                </div>
              </a>
              <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                <a class="dropdown-item" href="#">
                  <i class="mdi mdi-cached mr-2 text-success"></i> Altera Senha </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">
                  <i class="mdi mdi-logout mr-2 text-primary"></i> Sair </a>
              </div>
            </li>
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
          </button>
        </div>
      </nav>
      <div class="container-fluid page-body-wrapper">
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <!--<li class="nav-item nav-profile">
              <a href="#" class="nav-link">
                <div class="nav-profile-image">
                  <img src="assets/images/faces/face1.jpg" alt="profile">
                  <span class="login-status online"></span>
                </div>
                <div class="nav-profile-text d-flex flex-column">
                  <span class="font-weight-bold mb-2">David Grey. H</span>
                  <span class="text-secondary text-small">Project Manager</span>
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
              </a>
            </li>-->

            <?php foreach ($menu as $item_menu) { ?>
            <li class="nav-item">
                <?php if(empty($item_menu["link_men"]) || intval($item_menu["paginas"]) > 0) { ?>
                    <a class="nav-link" data-toggle="collapse" href="#ui-<?= $item_menu['icone_men'] ?>" aria-expanded="false" aria-controls="ui-basic">
                      <span class="menu-title"><?= $item_menu['nome_men'] ?></span>
                      <i class="menu-arrow"></i>
                      <i class="mdi <?= $item_menu['icone_men'] ?> menu-icon"></i>
                    </a>
                    <div class="collapse" id="ui-<?= $item_menu['icone_men'] ?>">
                      <ul class="nav flex-column sub-menu">
                        <?php foreach ($paginas as $item_pagina) {
                            if (($item_menu['codigo_men'] == $item_pagina['codigo_men']) && verifica_acesso($item_pagina['link_pag'], true)) { ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?= base_url($item_pagina['link_pag']) ?>"><?= $item_pagina['nome_pag'] ?></a>
                                </li>
                        <?php } } ?>
                      </ul>
                    </div>
                <?php }else{ ?>
                  <a class="nav-link" href="<?= $item_menu['link_men'] ?>">
                    <span class="menu-title"><?= $item_menu['nome_men'] ?></span>
                    <i class="mdi <?= $item_menu['icone_men'] ?> menu-icon"></i>
                  </a>
                <?php } ?>
            </li>
            <?php } ?>
          </ul>
        </nav>

        <!--
<!DOCTYPE html>
<html>

<head>
    <title>WP - Agendamento</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Web Prudente">
    <link rel="icon" type="image/ico" sizes="16x16" href="<?= base_url('assets/images/favicon.ico') ?>">
    <link href="<?= base_url('assets/plugins/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/plugins/jqueryui/jquery-ui.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/plugins/chartist-js/dist/chartist.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/plugins/chartist-js/dist/chartist-init.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/plugins/c3-master/c3.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/tema/style.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/tema/colors/blue.css') ?>" id="theme" rel="stylesheet">
    <link href="<?= base_url('assets/plugins/formValidation/formValidation.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/plugins/sweetalert/sweetalert.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/plugins/ajax-autocomplete/dist/css/ajax-bootstrap-select.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/plugins/bootstrap-select/bootstrap-select.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/plugins/toastr/toastr.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/cliente/estilo.css' . V) ?>" rel="stylesheet">

    <?php
    if (!empty($css_link)) {
        foreach ($css_link as $cada) { ?>
            <link href="<?= $cada . V ?>" rel="stylesheet">
    <?php } }

    if (!empty($css)) {
        foreach ($css as $cada) { ?>
            <link href="<?= base_url($cada . V) ?>" rel="stylesheet">
    <?php } } ?>
</head>

<body class="fix-header fix-sidebar card-no-border logo-center">
<input type="hidden" id="base_url" value="<?= base_url() ?>" />
<div class="preloader">
    <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
    </svg>
</div>
<div id="main-wrapper">
    <header class="topbar">
        <nav class="navbar top-navbar navbar-expand-md navbar-light">
            <div class="navbar-header">
            <a class="navbar-brand" href="#">
                        <span>
                            <img src="<?= base_url('assets/images/logo-wp.png') ?>" alt="homepage" class="dark-logo" />
                          
                            <img src="<?= base_url('assets/images/logo-wp-dark.png') ?>" alt="homepage" class="light-logo" />
                        </span>
            </div>

            <div class="navbar-collapse">
                <ul class="navbar-nav mr-auto mt-md-0">
                    <li class="nav-item">
                        <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)" style="position: absolute;top: 2px;font-size: 40px;left: 10px;"><i class="mdi mdi-menu"></i></a> 
                    </li>
                    <!--<li class="nav-item hidden-sm-down search-box"> <a class="nav-link hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-search"></i></a>
                        <form class="app-search">
                            <input type="text" class="form-control" placeholder="Search & enter">
                            <a class="srh-btn"><i class="ti-close"></i></a>
                        </form>
                    </li>

                    <li class="nav-item dropdown mega-dropdown"> <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="mdi mdi-view-grid"></i></a>
                        <div class="dropdown-menu scale-up-left">
                            <ul class="mega-dropdown-menu row">
                                <li class="col-lg-3 col-xlg-2 m-b-30">
                                    <h4 class="m-b-20">CAROUSEL</h4>

                                    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                        <div class="carousel-inner" role="listbox">
                                            <div class="carousel-item active">
                                                <div class="container"><img class="d-block img-fluid" src="<?= base_url('assets/images/big/img1.jpg') ?>" alt="First slide"></div>
                                            </div>
                                            <div class="carousel-item">
                                                <div class="container"><img class="d-block img-fluid" src="<?= base_url('assets/images/big/img2.jpg') ?>" alt="Second slide"></div>
                                            </div>
                                            <div class="carousel-item">
                                                <div class="container"><img class="d-block img-fluid" src="<?= base_url('assets/images/big/img3.jpg') ?>" alt="Third slide"></div>
                                            </div>
                                        </div>
                                        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a>
                                        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="sr-only">Next</span> </a>
                                    </div>

                                </li>
                                <li class="col-lg-3 m-b-30">
                                    <h4 class="m-b-20">ACCORDION</h4>

                                    <div id="accordion" class="nav-accordion" role="tablist" aria-multiselectable="true">
                                        <div class="card">
                                            <div class="card-header" role="tab" id="headingOne">
                                                <h5 class="mb-0">
                                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                        Collapsible Group Item #1
                                                    </a>
                                                </h5> </div>
                                            <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
                                                <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high. </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" role="tab" id="headingTwo">
                                                <h5 class="mb-0">
                                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                        Collapsible Group Item #2
                                                    </a>
                                                </h5> </div>
                                            <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                                                <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header" role="tab" id="headingThree">
                                                <h5 class="mb-0">
                                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                        Collapsible Group Item #3
                                                    </a>
                                                </h5> </div>
                                            <div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree">
                                                <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="col-lg-3  m-b-30">
                                    <h4 class="m-b-20">CONTACT US</h4>

                                    <form>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="exampleInputname1" placeholder="Enter Name"> </div>
                                        <div class="form-group">
                                            <input type="email" class="form-control" placeholder="Enter email"> </div>
                                        <div class="form-group">
                                            <textarea class="form-control" id="exampleTextarea" rows="3" placeholder="Message"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-info">Submit</button>
                                    </form>
                                </li>
                                <li class="col-lg-3 col-xlg-4 m-b-30">
                                    <h4 class="m-b-20">List style</h4>

                                    <ul class="list-style-none">
                                        <li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> You can give link</a></li>
                                        <li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> Give link</a></li>
                                        <li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> Another Give link</a></li>
                                        <li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> Forth link</a></li>
                                        <li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> Another fifth link</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </li>

                </ul>

                <ul class="navbar-nav my-lg-0">

                    <!--
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-muted text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-message"></i>
                            <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right mailbox scale-up">
                            <ul>
                                <li>
                                    <div class="drop-title">Notifications</div>
                                </li>
                                <li>
                                    <div class="message-center">

                                        <a href="#">
                                            <div class="btn btn-danger btn-circle"><i class="fa fa-link"></i></div>
                                            <div class="mail-contnet">
                                                <h5>Luanch Admin</h5> <span class="mail-desc">Just see the my new admin!</span> <span class="time">9:30 AM</span> </div>
                                        </a>

                                    </div>
                                </li>
                                <li>
                                    <a class="nav-link text-center" href="javascript:void(0);"> <strong>Check all notifications</strong> <i class="fa fa-angle-right"></i> </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" id="2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-email"></i>
                            <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                        </a>
                        <div class="dropdown-menu mailbox dropdown-menu-right scale-up" aria-labelledby="2">
                            <ul>
                                <li>
                                    <div class="drop-title">You have 4 new messages</div>
                                </li>
                                <li>
                                    <div class="message-center">

                                        <a href="#">
                                            <div class="user-img"> <img src="<?= base_url('assets/images/users/1.jpg') ?>" alt="user" class="img-circle"> <span class="profile-status online pull-right"></span> </div>
                                            <div class="mail-contnet">
                                                <h5>Pavan kumar</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:30 AM</span> </div>
                                        </a>

                                    </div>
                                </li>
                                <li>
                                    <a class="nav-link text-center" href="javascript:void(0);"> <strong>See all e-Mails</strong> <i class="fa fa-angle-right"></i> </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    --

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            
                            <button type="button" class="btn btn-warning btn-circle" style="text-align: center;padding: 11px 0;"><?= letras_iniciais($nome) ?></button>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right scale-up">
                            <ul class="dropdown-user">
                                <li>
                                    <div class="dw-user-box">
                                        <div class="u-img card-warning" style="height: 80px;color: #fff;font-size: 40px;line-height: 80px;text-align: center;">
                                            <!--<img src="<?= base_url('assets/images/users/1.jpg') ?>" alt="user">--
                                            <?= letras_iniciais($nome) ?>
                                        </div>

                                        <div class="u-text">
                                            <h4>
                                                <?= $array_nome[0]; ?>
                                            </h4>
                                            <p class="text-muted"><?= $email ?></p>
                                            <!--<a href="profile.html" class="btn btn-rounded btn-danger btn-sm">View Profile</a>--
                                        </div>
                                    </div>
                                </li>
                                <li role="separator" class="divider"></li>
                                <!--<li><a href="#"><i class="ti-user"></i> Meus Dados</a></li>
                                <!--<li><a href="#"><i class="ti-wallet"></i> My Balance</a></li>
                                <li><a href="#"><i class="ti-email"></i> Mensagens</a></li>
                                <li role="separator" class="divider"></li>
                                <!--<li><a href="#"><i class="ti-settings"></i> Account Setting</a></li>
                                <li role="separator" class="divider"></li>--
                                <li><a href="<?= base_url('login/sair') ?>"><i class="fa fa-power-off"></i> Sair</a></li>
                            </ul>
                        </div>
                    </li>

                    <!--
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="flag-icon flag-icon-us"></i></a>
                        <div class="dropdown-menu dropdown-menu-right scale-up"> <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-in"></i> India</a> <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-fr"></i> French</a> <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-cn"></i> China</a> <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-de"></i> Dutch</a> </div>
                    </li>
                    --
                </ul>
            </div>
        </nav>
    </header>

    <aside class="left-sidebar">
        <div class="scroll-sidebar">
            <nav class="sidebar-nav">
                <ul id="sidebarnav">
                    <?php foreach ($menu as $item_menu) { ?>
                    <li>
                        <?php if(empty($item_menu["link_men"]) || intval($item_menu["paginas"]) > 0) { ?>
                            <a class="has-arrow" href="#" aria-expanded="false"><i class="mdi <?= $item_menu['icone_men'] ?>"></i><span class="hide-menu"><?= $item_menu['nome_men'] ?></span></a>

                            <ul aria-expanded="false" class="collapse">
                                <?php foreach ($paginas as $item_pagina) {
                                    if (($item_menu['codigo_men'] == $item_pagina['codigo_men']) && verifica_acesso($item_pagina['link_pag'], true)) { ?>
                                        <li>
                                            <a href="<?= base_url($item_pagina['link_pag']) ?>"><?= $item_pagina['nome_pag'] ?></a>
                                        </li>
                                <?php } } ?>
                            </ul>
                        <?php }else{ ?>
                            <a class="has-arrow" href="<?= $item_menu['link_men'] ?>" aria-expanded="false"><i class="mdi <?= $item_menu['icone_men'] ?>"></i><span class="hide-menu"><?= $item_menu['nome_men'] ?></span></a>
                        <?php } ?>
                    </li>
                    <?php } ?>
                </ul>
            </nav>
        </div>
    </aside>

    <div class="page-wrapper">
        <div class="container-fluid">-->