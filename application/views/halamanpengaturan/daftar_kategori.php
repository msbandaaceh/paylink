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
                    <li class="active">
                        <a>
                            <i class="material-icons">toc</i>Pengaturan Kategori Potongan
                        </a>
                    </li>
                </ol>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header bg-light-blue">
                        <h2><i class="material-icons">subject</i>DAFTAR KATEGORI POTONGAN GAJI</h2>
                        <ul class="header-dropdown">
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"
                                    role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">note_add</i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li>
                                        <a class="waves-effect waves-block">
                                            <button
                                                onclick="loadKategori('<?= base64_encode($this->encryption->encrypt(-1)); ?>')"
                                                style="background: transparent; border: none !important;">
                                                Tambah Kategori Potongan
                                            </button>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>KATEGORI POTONGAN</th>
                                        <th>AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($kategori as $item) {
                                        ?>
                                        <tr>
                                            <td>
                                                <div class="font-18">
                                                    <?= $no; ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="font-18">
                                                    <?= $item->kategori; ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <a href="javascript:void(0);" class="dropdown-toggle"
                                                        data-toggle="dropdown" role="button" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <i class="material-icons">menu</i>
                                                    </a>
                                                    <ul class="dropdown-menu pull-right">
                                                        <li>
                                                            <a class="waves-effect waves-block">
                                                                <button
                                                                    onclick="loadKategori('<?= base64_encode($this->encryption->encrypt($item->id)); ?>')"
                                                                    style="background: transparent; border: none !important;">
                                                                    Edit Kategori
                                                                </button>
                                                            </a>
                                                            <a class="waves-effect waves-block">
                                                                <button
                                                                    onclick="hapusKategori('<?= base64_encode($this->encryption->encrypt($item->id)); ?>')"
                                                                    style="background: transparent; border: none !important;">
                                                                    Hapus Kategori
                                                                </button>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
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
                                        <th>KATEGORI POTONGAN</th>
                                        <th>AKSI</th>
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

<div class="modal fade" id="modalAddKategori" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" id="formSM" action="<?= site_url('simpan_kategori') ?>">
                <div class="modal-header">
                    <h5 class="modal-title align-center">
                        <div id="judul_"></div>
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="id" name="id">
                    </div>
                    <div class="form-group">
                        <div class="row g-2">
                            <div class="col">
                                <label for="nameBackdrop" class="form-label">NAMA KATEGORI</label>
                                <div class="form-line">
                                    <input type="text" id="kategori_" name="kategori" class="form-control"
                                        placeholder="Tuliskan Nama Kategori..">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="btnSimpan" class="btn btn-link waves-effect">SIMPAN KATEGORI</button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">TUTUP</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.content -->