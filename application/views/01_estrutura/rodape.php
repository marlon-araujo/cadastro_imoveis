            <input type="hidden" id="acoes" value='<?= json_encode($this->session->userdata(SS_PERMISSOES)) ?>'/>
        </div>
    </div>
    <script src="<?= base_url('assets/vendors/js/vendor.bundle.base.js') ?>"></script>
    <script src="<?= base_url('assets/vendors/chart.js/Chart.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/off-canvas.js') ?>"></script>
    <script src="<?= base_url('assets/js/hoverable-collapse.js') ?>"></script>
    <script src="<?= base_url('assets/js/misc.js') ?>"></script>
    <script src="<?= base_url('assets/js/dashboard.js') ?>"></script>
    <script src="<?= base_url('assets/js/todolist.js') ?>"></script>
    <script src="<?= base_url('assets/plugins/formValidation/formValidation.min.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/formValidation/framework/bootstrap.min.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/formValidation/language/pt_BR.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/sweetalert/sweetalert.min.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/jquery.toast/jquery.toast.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/toastr/toastr.min.js'); ?>"></script>
    <script src="<?= base_url('assets/plugins/accounting/accounting.min.js'); ?>"></script>
    <script src="<?= base_url('assets/js/paginas/geral.js'); ?>"></script>
    <?php
    if (!empty($js_link)) {
        foreach ($js_link as $cada) { ?>
            <script src="<?= $cada . V ?>"></script>
    <?php } }

    if (!empty($js)) {
        foreach ($js as $cada) { ?>
            <script src="<?= base_url($cada . V) ?>" ></script>
    <?php } } ?>
  </body>
</html>