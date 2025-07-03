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
                        <a class="active">
                            <i class="material-icons">list</i>Daftar Gaji Pegawai
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
                            DAFTAR GAJI
                        </h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table id="tabel-bulan" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>BULAN GAJI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($months as $month) {
                                        ?>
                                        <tr>
                                            <td>
                                                <?= $no; ?>
                                            </td>
                                            <td>
                                                <button id="bulan-gaji"
                                                    onclick="detailBulan('<?= base64_encode($this->encryption->encrypt($month['month'])) ?>')"
                                                    style="background: transparent; border: none !important;"><?= $month['konversi_tgl']; ?>
                                                </button>
                                            </td>
                                        </tr>
                                        <?php
                                        $no++;
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>NO</th>
                                        <th>BULAN GAJI</th>
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
<!-- /.content -->