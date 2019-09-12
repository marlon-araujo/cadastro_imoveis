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
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
          <div class="row flex-grow">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left p-5">
                <div class="brand-logo">
                  <img src="<?= base_url('assets/images/logo.svg') ?>">
                </div>
                <h4>Cadastro de Imóveis</h4>
                <form class="pt-3" id="form_logar" action="<?= base_url('login/entrar') ?>" method="POST">
                  <div class="form-group">
                    <input type="text" class="form-control form-control-lg" name="login" placeholder="Login">
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control-lg" name="senha" placeholder="Senha">
                  </div>
                  <div class="mt-3">
                    <button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">ENTRAR</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="<?= base_url('assets/plugins/jquery/jquery-3.4.1.min.js') ?>"></script>
    <script src="<?= base_url('assets/vendors/js/vendor.bundle.base.js') ?>"></script>
    <script src="<?= base_url('assets/js/off-canvas.js') ?>"></script>
    <script src="<?= base_url('assets/js/hoverable-collapse.js') ?>"></script>
    <script src="<?= base_url('assets/js/misc.js') ?>"></script>
    <script src="<?= base_url('assets/plugins/formValidation/formValidation.min.js') ?>"></script>
    <script src="<?= base_url('assets/plugins/formValidation/framework/bootstrap.min.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/formValidation/language/pt_BR.js'); ?>"></script>
    <script src="<?= base_url('assets/js/paginas/login.js') ?>"></script>
  </body>
</html>