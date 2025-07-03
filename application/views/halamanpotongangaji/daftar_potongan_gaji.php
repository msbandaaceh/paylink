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
                            <i class="material-icons">list</i>Daftar Bulan Gaji
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
                            DAFTAR BULAN GAJI
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
                                            <form action="<?= site_url('generate_gaji') ?>" method="POST">
                                                <button id="upload"
                                                    style="background: transparent; border: none !important;">
                                                    Generate Gaji Pegawai
                                                </button>
                                            </form>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table id="tabel-bulan" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>BULAN GAJI</th>
                                        <th>JUMLAH PEGAWAI</th>
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
                                                <button id="bulan-gaji" onclick="detailPotonganBulan('<?= $month['month']; ?>')"
                                                    style="background: transparent; border: none !important;"><?= $month['konversi_tgl']; ?>
                                                </button>
                                            </td>
                                            <td>
                                                <?= $month['pegawai_count']; ?>
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
                                        <th>JUMLAH PEGAWAI</th>
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