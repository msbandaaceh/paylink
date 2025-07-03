<!-- Navbar -->
<nav class="navbar">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="javascript:void(0);" class="bars"></a>
            <a class="navbar-brand" href="<?= site_url('') ?>">Slip Gaji Pegawai - Beranda</a>
        </div>
    </div>
</nav>
<!-- /.navbar -->

<section>
    <!-- Left Sidebar -->
    <aside id="leftsidebar" class="sidebar">
        <!-- User Info -->
        <div class="user-info">
            <div class="image">
                <img src="<?= $this->session->userdata('foto'); ?>" width="48" height="48" alt="User" />
            </div>
            <div class="info-container">
                <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?= $this->session->userdata("fullname"); ?>
                </div>
                <div class="email"><?= $this->session->userdata("jabatan"); ?></div>
            </div>
        </div>
        <!-- #User Info -->
        <!-- Menu -->
        <div class="menu">
            <ul class="list">
                <?php if ($side == 'main') {
                    echo '<li class="active">';
                    echo '<a>';
                } else {
                    echo '<li>';
                    echo '<a href=' . site_url("") . '>';
                } ?>
                <i class="material-icons">home</i>
                <span>Beranda</span>
                </a>
                </li>
                <?php if ($side == 'gaji') {
                    echo '<li class="active">';
                    echo '<a>';
                } else {
                    echo '<li>';
                    echo '<a href=' . site_url("daftar_gaji") . '>';
                } ?>
                <i class="material-icons">library_books</i>
                <span>Daftar Gaji Pegawai</span>
                </a>
                </li>
                <?php
                if ($peran == 'admin') {
                    ?>
                    <?php if ($side == 'potongan_gaji') {
                        echo '<li class="active">';
                        echo '<a>';
                    } else {
                        echo '<li>';
                        echo '<a href=' . site_url("daftar_potongan_gaji") . '>';
                    } ?>
                    <i class="material-icons">library_books</i>
                    <span>Daftar Potongan Gaji</span>
                    </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">build</i>
                            <span>Pengaturan</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="<?= site_url('kategori_potongan') ?>">Kategori Potongan</a>
                            </li>
                        </ul>
                    </li>
                <?php } ?>
                <li>
                    <a href="<?= $this->config->item('sso_server') ?>">
                        <i class="material-icons">exit_to_app</i>
                        <span>Keluar</span></a>
                </li>
            </ul>
        </div>
        <!-- #Menu -->
        <!-- Footer -->
        <div class="legal">
            <div class="copyright">
                &copy; 2024 <a href="">MS Banda Aceh</a>.
            </div>
            <div class="version">
                <b>Version: </b> 1.0.0
            </div>
        </div>
        <!-- #Footer -->
    </aside>
    <!-- #END# Left Sidebar -->

</section>