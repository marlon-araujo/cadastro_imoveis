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