<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title><?= $this->session->userdata('nama_client_app') ?> | <?= $this->session->userdata('deskripsi_client_app') ?>
    </title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= site_url('assets/icon/slip.ico'); ?>" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="<?= site_url('assets/plugins/bootstrap/css/bootstrap.css') ?>" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="<?= site_url('assets/plugins/node-waves/waves.css') ?>" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="<?= site_url('assets/plugins/animate-css/animate.css') ?>" rel="stylesheet" />

    <!-- Bootstrap Select Css -->
    <link href="<?= site_url('assets/plugins/bootstrap-select/css/bootstrap-select.css') ?>" rel="stylesheet" />

    <!-- Sweetalert Css -->
    <link href="<?= site_url('assets/plugins/sweetalert/sweetalert.css') ?>" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="<?= site_url('assets/css/style.css') ?>" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="<?= site_url('assets/css/themes/all-themes.css') ?>" rel="stylesheet" />

    <?php if ($page == 'dashboard') { ?>
        <link href="<?= site_url('assets/plugins/select2/css/select2.min.css') ?>" rel="stylesheet" />
    <?php }

    if (in_array($page, ['daftar'])) {
        ?>
        <!-- DataTables -->
        <link rel="stylesheet" href="<?= site_url('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>">
        <link rel="stylesheet"
            href="<?= site_url('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') ?>">
        <link rel="stylesheet" href="<?= site_url('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') ?>">
    <?php } ?>

    <style>
        /* Styling untuk modal agar tidak tampil di print preview */
        @media print {
            body * {
                visibility: hidden;
            }

            #modalPrint,
            #modalPrint * {
                visibility: visible;
            }

            #kakiModal,
            #kakiModal * {
                visibility: hidden;
            }

            #modalPrint {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                overflow: hidden;
                /* Hilangkan scrollbar */
                margin: 0;
                /* Hilangkan margin default */
                font-size: 10pt;
                /* Mengurangi ukuran font untuk menghemat ruang */
                padding: 10px;
                /* Mengurangi padding */
            }

            #modalPrint .modal-dialog {
                max-width: 100%;
                margin: 0;
            }

            #modalPrint .modal-content {
                height: auto;
                overflow: hidden;
                /* Pastikan konten tidak overflow */
                padding: 10px;
            }

            /* Mencegah pemecahan halaman */
            #modalPrint .modal-content,
            #modalPrint .modal-body {
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body class="theme-indigo">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Mohon Tunggu Sebentar...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->