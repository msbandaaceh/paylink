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
        #die(var_dump($this->session->all_userdata()));
        $data = array(
            'page' => 'dashboard',
            'side' => 'main',
            'peran' => $this->session->userdata('peran')
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
        $id = $this->input->post('id');
        $pegawai = $this->input->post('pegawai');
        $peran = $this->input->post('peran');

        if ($id) {
            $data = array(
                'userid' => $pegawai,
                'role' => $peran,
                'modified_by' => $this->session->userdata('fullname'),
                'modified_on' => date('Y-m-d H:i:s')
            );

            $query = $this->model->pembaharuan_data('peran', $data, 'id', $id);
        } else {
            $query = $this->model->get_seleksi('peran', 'userid', $pegawai);
            if ($query->num_rows() > 0) {
                $this->session->set_flashdata('info', '2');
                $this->session->set_flashdata('pesan_gagal', 'Pegawai tersebut sudah memiliki peran');
                redirect('');
                return;
            }

            $data = array(
                'userid' => $pegawai,
                'role' => $peran,
                'created_by' => $this->session->userdata('fullname'),
                'created_on' => date('Y-m-d H:i:s')
            );
            $query = $this->model->simpan_data('peran', $data);
        }

        if ($query == '1') {
            $this->session->set_flashdata('info', '1');
            $this->session->set_flashdata('pesan_sukses', 'Peran Pegawai telah disimpan');
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
        $sso_server = $this->session->userdata('sso_server');
        $this->session->sess_destroy();
        redirect($sso_server . '/keluar');
    }
}