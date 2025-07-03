<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'HalamanUtama';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['daftar_gaji'] = 'HalamanGaji';
$route['detail_gaji'] = 'HalamanGaji/detail_gaji';
$route['detail_potongan_gaji'] = 'HalamanGaji/detail_potongan_gaji';
$route['get_detail_potongan_gaji'] = 'HalamanGaji/get_detail_potongan_gaji_bulanan_pegawai';
$route['get_detail_potongan_gaji_pegawai'] = 'HalamanGaji/get_detail_potongan_gaji_pegawai';
$route['get_detail_potongan_gaji_per_pegawai'] = 'HalamanGaji/get_detail_potongan_gaji_per_pegawai';
$route['daftar_potongan_gaji'] = 'HalamanGaji/daftar_potongan_gaji';
$route['generate_gaji'] = 'HalamanGaji/generate_gaji';

$route['kategori_potongan'] = 'HalamanPengaturan/kategori_potongan';

$route['show_role'] = 'HalamanUtama/show';
$route['show_kategori'] = 'HalamanPengaturan/show_kategori';

$route['hapus_kategori'] = 'HalamanPengaturan/hapus_kategori';

$route['simpan_peran'] = 'HalamanUtama/simpan_peran';
$route['simpan_kategori'] = 'HalamanPengaturan/simpan_kategori';
$route['simpan_gaji_kotor'] = 'HalamanGaji/simpan_gaji_kotor';
$route['simpan_potongan_gaji'] = 'HalamanGaji/simpan_potongan_gaji';

$route['aktif_peran'] = 'HalamanUtama/aktif_peran';
$route['blok_peran'] = 'HalamanUtama/blok_peran';
