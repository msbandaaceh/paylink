<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HalamanPengaturan extends MY_Controller
{
    public function kategori_potongan()
    {
        $data = array(
            'page' => 'daftar',
            'side' => 'setting',
            'peran' => $this->session->userdata('peran')
        );
        $data['kategori'] = $this->model->show_all_kategori();

        $this->load->view('header', $data);
        $this->load->view('halamanpengaturan/sidebar');
        $this->load->view('halamanpengaturan/daftar_kategori');
        $this->load->view('footer');
    }

    public function simpan_kategori()
    {
        $id = $this->input->post('id');
        $kategori = $this->input->post('kategori');

        if ($id == "-1") {
            //buat agenda rapat baru
            $data = array(
                "kategori" => $kategori
            );

            $query = $this->model->simpan_data('ref_ref_potongan', $data);
        } else {
            $data = array(
                "kategori" => $kategori
            );

            $query = $this->model->pembaharuan_data('ref_potongan', $data, 'id', $id);
        }

        if ($query == 1) {
            $this->session->set_flashdata('info', '1');
            if ($id == '-1') {
                $this->session->set_flashdata('pesan_sukses', 'Kategori Potongan Berhasil di Tambahkan');
            } else {
                $this->session->set_flashdata('pesan_sukses', 'Kategori Potongan Berhasil di Perbarui');
            }
        } else {
            $this->session->set_flashdata('info', '3');
            $this->session->set_flashdata('pesan_gagal', 'Gagal Simpan Kategori Potongan, ' . $query);
        }
        //die(var_dump($notif));

        redirect('kategori_potongan');
    }

    public function show_kategori()
    {
        $id = $this->encryption->decrypt(base64_decode($this->input->post('id')));

        if ($id == '-1') {
            $judul = "TAMBAH DATA KATEGORI POTONGAN";
            $kategori = "";
        } else {
            $judul = "EDIT DATA KATEGORI POTONGAN";
            $kategori = $this->model->get_seleksi_kategori($id)->row()->kategori;
        }

        echo json_encode(
            array(
                'st' => 1,
                'id' => $id,
                'judul' => $judul,
                'kategori' => $kategori,
            )
        );
        return;
    }

    public function hapus_kategori()
    {
        $id = $this->encryption->decrypt(base64_decode($this->input->post('id')));
        $cekKategori = $this->model->cek_kategori($id);
        if ($cekKategori) {
            echo json_encode(
                array(
                    'st' => 2
                )
            );
        } else {
            $hapus = $this->model->hapus_kategori($id);

            if ($hapus == 1) {
                echo json_encode(
                    array(
                        'st' => 1
                    )
                );
            } else {
                echo json_encode(
                    array(
                        'st' => 0
                    )
                );
            }
        }

        return;
    }
}