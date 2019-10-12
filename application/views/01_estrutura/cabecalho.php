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
    <link rel="stylesheet" href="<?= base_url('assets/plugins/formValidation/formValidation.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/plugins/sweetalert/sweetalert.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/plugins/jquery.toast/jquery.toast.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/plugins/toastr/toastr.css') ?>">
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
    <style>
        .modal-title{
            left: 15px;
            position: absolute;
            top: 10px;
        }

        .table thead th {
            border-top: 1px solid #ebedf2;
        }

        .spinner {
          --spinner-size: 13;
          --line-color: #0ebeff;
          --line-alpha: 0.61;
          --ring-color: #000000;
          --ring-alpha: 0.25;
          --ring-size: 1;

          font-size: calc(var(--spinner-size) * 1em);
          width: 1em;
          height: 1em;
          border-radius: 50%;

          position: absolute;
          top: 50%;
          left: 50%;
          margin-top: -104px;
          margin-left: -104px;
        }
        .spinner .line {
          fill: none;
          stroke: var(--line-color);
          stroke-width: var(--ring-size);
          opacity: var(--line-alpha);
          stroke-linecap: round;
          transform-origin: 50% 50%;
          transform: rotate3d(0, 0, 1, 0deg);
          animation: 
            2156ms spinner-arc ease-in-out infinite,
            1829ms spinner-rotate linear infinite;
        }
        .spinner .ring {
          fill: none;
          stroke: var(--ring-color);
          stroke-width: var(--ring-size);
          opacity: var(--ring-alpha);
        }
        @keyframes spinner-rotate {
          to { transform: rotate3d(0, 0, 1, 360deg); }
        }
        @keyframes spinner-arc {
          from { stroke-dasharray: 0 150; stroke-dashoffset: 0; }
          to { stroke-dasharray: 100 150; stroke-dashoffset: -140; }
        }

        .carregando{
          display: none;
          position: fixed;
          z-index: 9999999;
          background: rgba(0,0,0,0.5);
          top: 0;
          bottom: 0;
          right: 0;
          left: 0;
        }
    </style>
  </head>

    <div class="carregando">
      <svg viewBox="0 0 50 50" class="spinner">
        <circle class="ring" cx="25" cy="25" r="22.5" />
        <circle class="line" cx="25" cy="25" r="22.5" />
      </svg>
    </div>
    <input type="hidden" id="base_url" value="<?= base_url() ?>" />

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
                <a class="dropdown-item" href="<?= base_url('login/sair') ?>">
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
