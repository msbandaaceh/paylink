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
                        <a href="<?= site_url('daftar_potongan_gaji') ?>">
                            <i class="material-icons">list</i>Daftar Bulan Gaji
                        </a>
                    </li>
                    <li class="active">
                        <a>
                            <i class="material-icons">list</i>Bulan
                            <?= $this->tanggalhelper->convertMonthDate($periode_gaji) ?>
                        </a>
                    </li>
                </ol>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header bg-light-blue">
                        <h2>
                            DAFTAR POTONGAN GAJI BULAN
                            <?= $this->tanggalhelper->convertMonthDate($periode_gaji) ?>
                        </h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table id="daftar_potongan" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>NAMA PEGAWAI</th>
                                        <th>GAJI KOTOR</th>
                                        <th>TOTAL POTONGAN</th>
                                        <th>GAJI BERSIH</th>
                                    </tr>
                                </thead>
                                <tbody id="bodyTabel">
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>NO</th>
                                        <th>NAMA PEGAWAI</th>
                                        <th>GAJI KOTOR</th>
                                        <th>TOTAL POTONGAN</th>
                                        <th>GAJI BERSIH</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="modalPotongan" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="judulTab">Modal title</h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="tblPotongan" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>JENIS POTONGAN</th>
                                <th>BESAR POTONGAN</th>
                            </tr>
                        </thead>
                        <tbody id="bodyPotongan">
                        </tbody>
                        <tfoot>
                            <th>NO</th>
                            <th>JENIS POTONGAN</th>
                            <th>BESAR POTONGAN</th>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="fetchQueues()" class="btn btn-link waves-effect"
                    data-dismiss="modal">SIMPAN</button>
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

<script
    src="<?= site_url('assets/plugins/jquery-inputmask/jquery.inputmask.bundle.js') ?>"></script>
<script src="<?= site_url('assets/plugins/jquery-countto/jquery.countTo.js') ?>"></script>
<script src="<?= site_url('assets/plugins/editable-table/mindmup-editabletable.js') ?>"></script>

<script>

    $(document).ready(function () {
        //console.log("ready!");
        fetchQueues();
        //setInterval(fetchQueues, 2000);

        $('#daftar_potongan').on('change', 'td.editable', function (evt, newValue) {
            var id = $(this).data('id');
            var gaji_kotor = newValue;
            //console.log (id + " dan "+gaji_kotor);

            $.post("<?= site_url('simpan_gaji_kotor') ?>", {
                id: id,
                gaji_kotor: gaji_kotor
            }, function (response) {
                fetchQueues();
            }, 'json');

        });

        $('#tblPotongan').on('change', 'td.editable', function (evt, newValue) {
            var id = $(this).data('id');
            var pot = newValue;

            $.post("<?= site_url('simpan_potongan_gaji') ?>", {
                id: id,
                pot: pot
            }, function (response) {
            }, 'json');

        });
    });

    function fetchQueues() {
        var bulan = '<?= $bulan_gaji ?>';

        $.ajax({
            url: 'get_detail_potongan_gaji_pegawai',
            data: { bulan: bulan },
            method: 'GET',
            success: function (data) {
                var queues = JSON.parse(data);
                var bodyTabel = $('#bodyTabel');
                bodyTabel.empty();
                queues.forEach(function (queue, index) {
                    var index = index + 1;
                    //console.log(queue.gaji);
                    var konvertGaji = formatToIDR(queue.gaji);
                    var konvertPot = formatToIDR(queue.total_potongan);
                    var gaji = formatToIDR(queue.gaji - queue.total_potongan);
                    var row = '<tr><td>' + index + '</td><td>' + queue.nama + '</td><td class="editable" data-id="' + queue.id_gaji + '">' + konvertGaji + '</td><td><button class="btn-block align-left" data-toggle="modal" data-target="#modalPotongan" onclick="detailPotongan(\'' + queue.nama + '\', ' + queue.id_pegawai + ',\'' + bulan + '\')" style = "background: transparent; border: none !important;"> ' + konvertPot + '</button></td > <td>' + gaji + '</td></tr > ';
                    bodyTabel.append(row);
                });

                $('#daftar_potongan').editableTableWidget();
            }
        });
    }

    function fetchPotongan(id_pegawai) {
        var bulan = '<?= $bulan_gaji ?>';
        //console.log(bulan);
        var id = id_pegawai;
        $.ajax({
            url: 'get_detail_potongan_gaji_per_pegawai',
            data: { bulan: bulan, id: id },
            method: 'GET',
            success: function (data) {
                var queues = JSON.parse(data);
                var bodyTabel = $('#bodyPotongan');
                var judul = $('#judulTab');
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
                        var row = '<tr><td>' + index + '</td><td>' + queue.kategori + '</td><td class="editable" data-id="' + queue.id + '">' + konvertPot + '</td></tr>';
                        bodyTabel.append(row);
                        judul.empty();
                        judul.append(queue.nama);
                    });

                    $('#tblPotongan').editableTableWidget();
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

    function detailPotongan(nama, id, bulan) {
        fetchPotongan(id);
        /*
        var form = $('<form action="<?= base_url() ?>detail_pot_gaji_pegawai" method="post">' +
        '<input type="hidden" name="id_pegawai" value="' + id + '">' +
            '<input type="hidden" name="nama" value="' + nama + '">' +
            '<input type="hidden" name="bulan" value="' + bulan + '">' +
            '</form>');
        // Menambahkan formulir ke dalam dokumen
        $('body').append(form);
        // Mengirimkan formulir
        form.submit();
        */
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