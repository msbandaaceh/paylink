<!-- Core JS -->
<!-- Jquery Core Js -->
<script src="<?= site_url('assets/plugins/jquery/jquery.min.js') ?>"></script>

<!-- Bootstrap Core Js -->
<script src="<?= site_url('assets/plugins/bootstrap/js/bootstrap.js') ?>"></script>

<!-- Select Plugin Js -->
<script src="<?= site_url('assets/plugins/bootstrap-select/js/bootstrap-select.js') ?>"></script>

<!-- Slimscroll Plugin Js -->
<script src="<?= site_url('assets/plugins/jquery-slimscroll/jquery.slimscroll.js') ?>"></script>

<!-- Waves Effect Plugin Js -->
<script src="<?= site_url('assets/plugins/node-waves/waves.js') ?>"></script>

<!-- Jquery CountTo Plugin Js -->
<script src="<?= site_url('assets/plugins/jquery-countto/jquery.countTo.js') ?>"></script>

<!-- SweetAlert Plugin Js -->
<script src="<?= site_url('assets/plugins/sweetalert/sweetalert.min.js') ?>"></script>

<!-- Select2 Plugin Js -->
<script src="<?= site_url('assets/plugins/select2/js/select2.min.js') ?>"></script>

<!-- Custom Js -->
<script src="<?= site_url('assets/js/admin.js') ?>"></script>

<?php
if (in_array($page, ['daftar'])) {
    ?>
    <!-- DataTables  & Plugins -->
    <script src="<?= site_url('assets/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
    <script src="<?= site_url('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
    <script src="<?= site_url('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') ?>"></script>
    <script src="<?= site_url('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') ?>"></script>
    <script src="<?= site_url('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') ?>"></script>
    <script src="<?= site_url('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') ?>"></script>
    <script src="<?= site_url('assets/plugins/jszip/jszip.min.js') ?>"></script>
    <script src="<?= site_url('assets/plugins/pdfmake/pdfmake.min.js') ?>"></script>
    <script src="<?= site_url('assets/plugins/pdfmake/vfs_fonts.js') ?>"></script>
    <script src="<?= site_url('assets/plugins/datatables-buttons/js/buttons.html5.min.js') ?>"></script>
    <script src="<?= site_url('assets/plugins/datatables-buttons/js/buttons.print.min.js') ?>"></script>
    <script src="<?= site_url('assets/plugins/datatables-buttons/js/buttons.colVis.min.js') ?>"></script>
<?php } ?>

<?php
if ($this->session->flashdata('info')) {
    $result = $this->session->flashdata('info');
    if ($result == '1') {
        $pesan = $this->session->flashdata('pesan_sukses');
    } elseif ($result == '2') {
        $pesan = $this->session->flashdata('pesan_gagal');
    } else {
        $pesan = $this->session->flashdata('pesan_gagal');
    }
} else {
    $result = "-1";
    $pesan = "";
}
?>

<script type="text/javascript">
    var config = {
        result: '<?= $result ?>',
        pesan: '<?= $pesan ?>'
    };
</script>

<script src="<?= site_url('assets/js/gaji.js'); ?>"></script>
<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>

</body>

</html>