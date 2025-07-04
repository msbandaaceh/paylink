<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HalamanUtama extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = array(
            'page' => 'dashboard',
            'side' => 'main',
            'peran' => $this->peran
        );

        $this->load->view('header', $data);
        $this->load->view('sidebar');
        $this->load->view('dashboard');
        $this->load->view('footer');
    }

    public function show()
    {
        $id = $this->input->post('id');
        $data = $this->model->get_data_peran_modal($id);
        echo json_encode($data);
    }

    public function simpan_peran()
    {
        $input = $this->input->post();
        $result = $this->model->simpan_peran($input);

        if ($result === true) {
            $this->session->set_flashdata('info', '1');
            $this->session->set_flashdata('pesan_sukses', 'Peran Pegawai telah disimpan');
        } elseif ($result === 'duplikat') {
            $this->session->set_flashdata('info', '2');
            $this->session->set_flashdata('pesan_gagal', 'Pegawai tersebut sudah memiliki peran');
        } else {
            $this->session->set_flashdata('info', '3');
            $this->session->set_flashdata('pesan_gagal', 'Peran Pegawai gagal disimpan');
        }

        redirect('/');
    }

    public function aktif_peran()
    {
        $id = $this->input->post('id');
        $success = $this->model->ubah_status_peran($id, '0');
        echo json_encode(['st' => $success ? '1' : '0']);
    }

    public function blok_peran()
    {
        $id = $this->input->post('id');
        $success = $this->model->ubah_status_peran($id, '1');
        echo json_encode(['st' => $success ? '1' : '0']);
    }

    public function keluar()
    {
        $this->session->sess_destroy();
        redirect($this->config->item('sso_server') . '/keluar');
    }
}