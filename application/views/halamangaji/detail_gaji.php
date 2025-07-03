<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <ol class="breadcrumb align-right">
                    <li>
                        <a href="<?= site_url('') ?>">
                            <i class="material-icons">home</i>Beranda
                        </a>
                    </li>
                    <li>
                        <a href="<?= site_url('daftar_gaji') ?>">
                            <i class="material-icons">list</i>Daftar Gaji
                        </a>
                    </li>
                    <li class="active">
                        <a>
                            <i class="material-icons">person_pin</i><?= $this->session->userdata("fullname") ?>
                        </a>
                    </li>
                </ol>
            </div>
        </div>

        <?php
        $no = 1;
        foreach ($gaji as $item) {
            ?>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="info-box-2 bg-pink hover-zoom-effect">
                        <div class="icon">
                            <i class="material-icons">credit_card</i>
                        </div>
                        <div class="content">
                            <div class="text">GAJI</div>
                            <div class="number"><?php $gaji_kotor = "Rp. " . number_format($item->gaji, 2, ',', '.');
                            echo $gaji_kotor; ?></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="info-box-2 bg-blue hover-zoom-effect">
                        <div class="icon">
                            <i class="material-icons">credit_card</i>
                        </div>
                        <div class="content">
                            <div class="text">POTONGAN</div>
                            <div class="number"><?php $pot = "Rp. " . number_format($item->total_potongan, 2, ',', '.');
                            echo $pot; ?></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="info-box-2 bg-light-blue hover-zoom-effect">
                        <div class="icon">
                            <i class="material-icons">credit_card</i>
                        </div>
                        <div class="content">
                            <div class="text">GAJI BERSIH</div>
                            <div class="number"><?php $gaji = "Rp. " . number_format($item->gaji - $item->total_potongan, 2, ',', '.');
                            echo $gaji; ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $no++;
        }
        ?>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header bg-light-blue">
                        <h2>
                            DAFTAR POTONGAN GAJI BULAN
                            <?= $this->tanggalhelper->convertMonthDate($periode_gaji) ?>
                        </h2>

                        <ul class="header-dropdown">
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"
                                    role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">more_vert</i>
                                </a>

                                <ul class="dropdown-menu pull-right">
                                    <li>
                                        <a class="waves-effect waves-block">
                                            <button data-toggle="modal" data-target="#modalPrint"
                                                style="background: transparent; border: none !important;"
                                                onclick="fetchCetak('<?= $bulan_gaji ?>', '<?= $id_pegawai ?>')">
                                                Cetak Rincian Gaji
                                            </button>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table id="example" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>JENIS POTONGAN</th>
                                        <th>BESAR POTONGAN</th>
                                    </tr>
                                </thead>
                                <tbody id="bodyTabel">
                                </tbody>
                                <tfoot>
                                    <th>NO</th>
                                    <th>JENIS POTONGAN</th>
                                    <th>BESAR POTONGAN</th>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="modalPrint" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title align-center">DAFTAR RINCIAN PEMBAYARAN GAJI</h4>
                <hr>
                <p>Nama Pegawai : <?= $this->session->userdata("fullname") ?></p>
                <p>Gaji Bulan : <?= $this->tanggalhelper->convertMonthDate($periode_gaji) ?>
                </p>
            </div>
            <div class="modal-body table-responsive">
                <table class="table">
                    <tbody>
                        <tr>
                            <th>A.</th>
                            <th>Jumlah yang ditransfer ke bank</th>
                            <th class="align-right"><?= $gaji_kotor ?></th>
                        </tr>
                        <tr>
                            <th>B.</th>
                            <th scope="row">Potongan - potongan</th>
                        </tr>
                    </tbody>
                </table>
                <table class="table">
                    <tbody id="bodyPrint"></tbody>
                </table>
                <table class="table">
                    <tbody>
                        <tr>
                            <th></th>
                            <th>Jumlah Potongan - potongan</th>
                            <th>:</th>
                            <th class="align-left"><?= $pot ?></th>
                        </tr>
                        <tr>
                            <th></th>
                            <th>Jumlah Gaji bersih yang diterima</th>
                            <th>:</th>
                            <th class="align-right"><?= $gaji ?></th>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="kakiModal" class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" onclick="printModalContent()">CETAK</button>
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">TUTUP</button>
            </div>
        </div>
    </div>
</div>

<script src="<?= site_url('assets/plugins/jquery/jquery.min.js') ?>"></script>
<script src="<?= site_url('assets/plugins/bootstrap/js/bootstrap.js') ?>"></script>
<script src="<?= site_url('assets/plugins/bootstrap-select/js/bootstrap-select.js') ?>"></script>
<script src="<?= site_url('assets/plugins/jquery-slimscroll/jquery.slimscroll.js') ?>"></script>
<script src="<?= site_url('assets/plugins/node-waves/waves.js') ?>"></script>
<script src="<?= site_url('assets/js/admin.js') ?>"></script>

<script>

    $(document).ready(function () {
        //console.log("ready!");
        fetchGaji('<?= $bulan_gaji ?>', '<?= $id_pegawai ?>');
    });

    function printModalContent() {
        window.print();
    }

    function fetchGaji(bulan, id) {
        $.ajax({
            url: 'get_detail_potongan_gaji',
            data: { bulan: bulan, id: id },
            method: 'GET',
            success: function (data) {
                var queues = JSON.parse(data);
                var bodyTabel = $('#bodyTabel');
                bodyTabel.empty();
                if (queues === null || queues === 'null' || queues.length === 0) {
                    // Show an alert or display a message in the table
                    var row = '<tr><td class = "text-center font-italic" colspan="3">-- Belum Ada Data --</td></tr>';
                    bodyTabel.append(row);
                } else {
                    var queues = JSON.parse(data);
                    queues.forEach(function (queue, index) {
                        var index = index + 1;
                        var konvertPot = formatToIDR(queue.potongan); // Changed from 'potongan' to 'queue.potongan_gaji'
                        var row = '<tr><td>' + index + '</td><td>' + queue.kategori + '</td><td>' + konvertPot + '</td></tr>';
                        bodyTabel.append(row);
                    });

                    //$('#example').editableTableWidget();
                }
            }
        });
    }

    function fetchCetak(bulan, id) {
        $.ajax({
            url: 'get_detail_potongan_gaji',
            data: { bulan: bulan, id: id },
            method: 'GET',
            success: function (data) {
                var queues = JSON.parse(data);
                var bodyTabel = $('#bodyPrint');
                bodyTabel.empty();
                if (queues === null || queues === 'null' || queues.length === 0) {
                    // Show an alert or display a message in the table
                    var row = '<tr><td class = "text-center font-italic" colspan="3">-- Belum Ada Data --</td></tr>';
                    bodyTabel.append(row);
                } else {
                    var queues = JSON.parse(data);
                    queues.forEach(function (queue, index) {
                        var index = index + 1;
                        var konvertPot = formatToIDR(queue.potongan); // Changed from 'potongan' to 'queue.potongan_gaji'
                        var row = '<tr><td>' + index + '</td><td>' + queue.kategori + '</td><td>' + konvertPot + '</td></tr>';
                        bodyTabel.append(row);
                    });

                    //$('#example').editableTableWidget();
                }
            }
        });
    }

    function formatToIDR(amount) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR'
        }).format(amount);
    }

</script>

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