<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HalamanGaji extends MY_Controller
{
    public function index()
    {
        if ($this->session->userdata('status_plh') == '1' || $this->session->userdata('status_plt') == '1') {
            $this->session->set_flashdata('info', '3');
            $this->session->set_flashdata('pesan_gagal', 'Anda tidak memiliki akses');
            redirect('/');
        }

        $months = $this->model->get_all_months();
        foreach ($months as &$month) {
            $month['pegawai_count'] = $this->model->get_pegawai_count_by_month($month['month']);
            $bulan = DateTime::createFromFormat('Y-m', $month['month']);
            $month['konversi_tgl'] = $this->tanggalhelper->convertMonthDate($month['month'] . '-01');
        }

        $data = array(
            'months' => $months,
            'page' => 'daftar',
            'side' => 'gaji',
            'peran' => $this->session->userdata('peran')
        );

        $this->load->view('header', $data);
        $this->load->view('sidebar');
        $this->load->view('halamangaji/daftar_bulan');
        $this->load->view('footer');
    }

    public function detail_gaji()
    {
        $bulan = $this->encryption->decrypt(base64_decode($this->input->post('tgl')));

        $id_pegawai = $this->model->get_pegawai_id();
        $data = array(
            'gaji' => $this->model->get_all_gaji_bulanan($bulan, $id_pegawai),
            'page' => 'daftar',
            'side' => 'gaji',
            'peran' => $this->session->userdata('peran'),
            'bulan_gaji' => $bulan,
            'periode_gaji' => $bulan . "-01",
            'id_pegawai' => $id_pegawai
        );

        $this->load->view('header', $data);
        $this->load->view('sidebar');
        $this->load->view('halamangaji/detail_gaji');
    }

    public function daftar_potongan_gaji()
    {
        $months = $this->model->get_all_months();
        foreach ($months as &$month) {
            $month['pegawai_count'] = $this->model->get_pegawai_count_by_month($month['month']);
            $bulan = DateTime::createFromFormat('Y-m', $month['month']);
            $month['konversi_tgl'] = $this->tanggalhelper->convertMonthDate($month['month'] . '-01');
        }

        //die(var_dump($bulan));
        $data = array(
            'months' => $months,
            'page' => 'daftar',
            'peran' => $this->session->userdata('peran'),
            'side' => 'potongan_gaji'
        );

        $this->load->view('header', $data);
        $this->load->view('sidebar');
        $this->load->view('halamanpotongangaji/daftar_potongan_gaji');
        $this->load->view('footer');
    }

    public function get_detail_potongan_gaji_bulanan_pegawai()
    {
        $bulan = $this->input->get('bulan');
        $id = $this->input->get('id');
        $potgaji = $this->model->get_all_potongan_bulanan_pegawai_json($bulan, $id);
        echo json_encode($potgaji);
    }

    public function generate_gaji()
    {
        $result = $this->model->generate_gaji_bulanan();

        switch ($result['status']) {
            case 'sukses':
                $this->session->set_flashdata('info', '1');
                $this->session->set_flashdata('pesan_sukses', 'Gaji berhasil digenerate');
                break;
            case 'sudah_ada':
                $this->session->set_flashdata('info', '2');
                $this->session->set_flashdata('pesan_gagal', 'Bulan ini sudah ada');
                break;
            case 'no_pegawai':
                $this->session->set_flashdata('info', '2');
                $this->session->set_flashdata('pesan_gagal', 'Tidak ada pegawai aktif');
                break;
        }

        redirect('daftar_potongan_gaji');
    }

    public function detail_potongan_gaji()
    {
        $bulan = $this->input->post('tgl');
        if ($bulan) {
            $data = array(
                'bulan_gaji' => $bulan,
                'periode_gaji' => $bulan . "-01",
                'peran' => $this->session->userdata('peran'),
                'page' => 'daftar',
                'side' => 'potongan_gaji'
            );
        }

        $this->load->view('header', $data);
        $this->load->view('sidebar');
        $this->load->view('halamanpotongangaji/daftar_detail_potongan_gaji');
    }

    public function simpan_gaji_kotor()
    {
        $id = $this->input->post('id');
        //die(var_dump($id));
        $gaji_kotor = $this->input->post('gaji_kotor');
        $data = array(
            'gaji' => $gaji_kotor,
            'modified_on' => date('Y-m-d H:i:s'),
            'modified_by' => $this->session->userdata("fullname")
        );

        $this->model->pembaharuan_data('register_gaji', $data, 'id', $id);
        echo json_encode(array("status" => TRUE));
    }

    public function get_detail_potongan_gaji_pegawai()
    {
        $bulan = $this->input->get('bulan');
        $potgaji = $this->model->show_all_gaji_bulanan_json($bulan);
        echo json_encode($potgaji);
    }

    public function get_detail_potongan_gaji_per_pegawai()
    {
        $bulan = $this->input->get('bulan');
        $id = $this->input->get('id');
        //die(var_dump($bulan." ".$id));
        $potgaji = $this->model->get_all_potongan_bulanan_pegawai_json($bulan, $id);
        //die(var_dump($potgaji));
        echo json_encode($potgaji);
    }

    public function simpan_potongan_gaji()
    {
        $id = $this->input->post('id');
        $pot = $this->input->post('pot');
        $data = array(
            'potongan' => $pot
        );

        $this->model->pembaharuan_data('register_potongan_gaji', $data, 'id', $id);
        echo json_encode(array("status" => TRUE));
    }

    public function cetak_slip_gaji_pegawai()
    {
        $id_pegawai = $this->session->userdata("id_pegawai");
        $periode = $this->session->userdata("periode_gaji");
    }
}