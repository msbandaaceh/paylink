<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <?php if ($peran == 'admin') { ?>
            <div class="row">
                <div class="col">
                    <div class="align-right">
                        <button class="btn btn-success" onclick="ModalRole('-1')"><i
                                class="material-icons">verified_user</i>
                            Peran</button>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="row">
            <div class="col">
                <ol class="breadcrumb align-right">
                    <li>
                        <a>
                            <i class="material-icons">home</i> Beranda
                            <?= $this->session->userdata('nama_client_app') ?>
                        </a>
                    </li>
                </ol>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header bg-light-blue">
                        <h2><i class="material-icons">announcement</i>INFORMASI</h2>
                    </div>
                    <div class="body">
                        <div class="panel-group" id="accordion_11" role="tablist" aria-multiselectable="true">
                            <div class="panel panel-col-blue">

                                <div class="panel-heading" role="tab" id="headingOne_100">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion_11"
                                            href="#collapseOne_100" aria-expanded="true"
                                            aria-controls="collapseOne_100">
                                            SISTEM INFORMASI POTONGAN GAJI versi 1.0.0
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseOne_100" class="panel-collapse collapse in" role="tabpanel"
                                    aria-labelledby="headingOne_100">
                                    <div class="panel-body">
                                        <h4>Fitur User Pegawai :</h4>
                                        <ol>
                                            <li>Informasi Gaji dan Potongan Gaji Bulanan Pegawai.
                                            </li>
                                        </ol>

                                        <h4>Fitur User Petugas PPABP :</h4>
                                        <ol>
                                            <li>Input Gaji dan Potongan Gaji Pegawai.
                                            </li>
                                        </ol>

                                        Buku Panduan penggunaan aplikasi dapat di unduh melalui tautan ini.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="role-pegawai" data-backdrop="static">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Daftar Petugas</h5>
                </div>
                <form method="POST" id="formSM" action="<?= site_url('simpan_peran') ?>">
                    <input type="hidden" id="id" name="id">
                    <div class="modal-body">
                        <div class="form-group">
                            <h5 class="form-label">Pilih Pegawai : </h5>
                            <div id="pegawai_">
                            </div>
                        </div>
                        <div class="form-group">
                            <h5 class="form-label">Pilih Peran : </h5>
                            <div id="peran_"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="btnSimpanKegiatan" class="btn btn-link waves-effect">Simpan
                            Petugas</button>
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Tutup</button>
                    </div>
                </form>

                <div class="modal-body" id="tabel-role">
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</section>
<!-- /.content -->