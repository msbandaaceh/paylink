<?php

class ModelGaji extends CI_Model
{
    private $db_sso;

    public function __construct()
    {
        parent::__construct();

        // Inisialisasi variabel private dengan nilai dari session
        $this->db_sso = $this->session->userdata('sso_db');
    }

    private function add_audittrail($action, $title, $table, $descrip)
    {
        $params = [
            'tabel' => 'sys_audittrail',
            'data' => [
                'datetime' => date("Y-m-d H:i:s"),
                'ipaddress' => $this->input->ip_address(),
                'action' => $action,
                'title' => $title,
                'tablename' => $table,
                'description' => $descrip,
                'username' => $this->session->userdata('username')
            ]
        ];

        $this->apihelper->post('apiclient/simpan_data', $params);
    }

    public function cek_aplikasi($id)
    {
        $params = [
            'tabel' => 'ref_client_app',
            'kolom_seleksi' => 'id',
            'seleksi' => $id
        ];

        $result = $this->apihelper->get('apiclient/get_data_seleksi', $params);

        if ($result['status_code'] === 200 && $result['response']['status'] === 'success') {
            $user_data = $result['response']['data'][0];
            $this->session->set_userdata(
                [
                    'nama_client_app' => $user_data['nama_app'],
                    'deskripsi_client_app' => $user_data['deskripsi']
                ]
            );
        }
    }

    public function get_token()
    {
        $params = [
            'tabel' => 'v_users',
            'kolom_seleksi' => 'userid',
            'seleksi' => $this->session->userdata("userid")
        ];

        $result = $this->apihelper->get('apiclient/get_data_seleksi', $params);

        if ($result['status_code'] === 200 && $result['response']['status'] === 'success') {
            $user_data = $result['response']['data'][0];
            $token = $user_data['token'];
        }

        return $token;
    }

    public function get_data_peran_modal($id)
    {
        $data = [
            "tabel" => "v_users",
            "kolom_seleksi" => "status_pegawai",
            "seleksi" => "1"
        ];

        $users = $this->apihelper->get('apiclient/get_data_seleksi', $data);

        $pegawai = array();
        if ($users['status_code'] === '200') {
            foreach ($users['response']['data'] as $item) {
                $pegawai[$item['userid']] = $item['fullname'];
            }
        }

        if ($id != '-1') {
            $query = $this->get_seleksi('peran', 'id', $id);

            $data = array(
                'pegawai' => $users['response']['data'],
                'role' => $pegawai,
                'id' => $query->row()->id,
                'editPegawai' => $query->row()->userid,
                'editPeran' => $query->row()->role
            );
        } else {
            $dataPeran = $this->get_data_peran();

            $data = array(
                'pegawai' => $users['response']['data'],
                'role' => $pegawai,
                'data_peran' => $dataPeran
            );
        }
        return $data;
    }

    public function get_pegawai_aktif()
    {
        $this->db->select('id');
        $this->db->where('status_pegawai', 1);
        $this->db->where_not_in('jenis_pegawai', array(5));
        $query = $this->db->get($this->db_sso . '.pegawai');
        return $query->result();
    }

    public function get_pegawai_id()
    {
        $params = [
            'tabel' => 'v_users',
            'kolom_seleksi' => 'userid',
            'seleksi' => $this->session->userdata("userid")
        ];

        $result = $this->apihelper->get('apiclient/get_data_seleksi', $params);

        if ($result['status_code'] === 200 && $result['response']['status'] === 'success') {
            $user_data = $result['response']['data'][0];
            $pegawai_id = $user_data['pegawai_id'];
        }

        return $pegawai_id;
    }

    public function show_all_kategori()
    {
        $this->db->select('*')
            ->from("ref_potongan");

        return $this->db->get()->result();
    }

    public function get_seleksi_kategori($id)
    {
        try {
            $this->db->where('id', $id);
            return $this->db->get('ref_potongan');
        } catch (Exception $e) {
            return $e;
        }
    }

    public function get_kategori_potongan()
    {
        $this->db->select('id');
        $query = $this->db->get('ref_potongan');
        return $query->result();
    }

    public function get_all_gaji_bulanan($bulan, $id)
    {
        $this->db->select('*')
            ->from("v_detail_gaji")
            ->where("id_pegawai", $id)
            ->where("bulan", $bulan);

        return $this->db->get()->result();
    }

    public function cek_pot_bulan_lalu($id_pegawai, $id, $bulan)
    {
        $this->db->select('*');
        $this->db->where("id_pegawai", $id_pegawai);
        $this->db->where("id_potongan", $id);
        $this->db->like('created_on', $bulan);
        return $this->db->get('register_potongan_gaji')->row();
    }

    public function get_all_potongan_bulanan_pegawai_json($bulan, $id)
    {
        $this->db->select('rp.id AS id, rp.id_pegawai AS id_pegawai, g.nama_gelar AS nama, rp.id_potongan AS id_potongan, p.kategori AS kategori, rp.potongan AS potongan, rp.created_on AS created_on')
            ->from("register_potongan_gaji rp")
            ->join("ref_potongan p", "rp.id_potongan = p.id", "left")
            ->join($this->db_sso . ".pegawai g", "rp.id_pegawai = g.id", "left")
            ->where("id_pegawai", $id)
            ->like("created_on", $bulan)
            ->order_by("rp.id");
        ;

        return $this->db->get()->result();
    }

    public function show_all_gaji_bulanan_json($bulan)
    {
        $this->db->select('*')
            ->from("v_detail_gaji")
            ->where("bulan", $bulan);

        return $this->db->get()->result_array();
    }

    public function generate_gaji_bulanan($bulan = null)
    {
        if (!$bulan)
            $bulan = date('Y-m');

        $active_pegawai = $this->get_pegawai_aktif();
        if (count($active_pegawai) == 0)
            return ['status' => 'no_pegawai'];

        if ($this->cekPeriode($bulan))
            return ['status' => 'sudah_ada'];

        $periode_lalu = date('Y-m', strtotime("$bulan -1 month"));
        $dataGaji = [];
        $dataPotongan = [];

        foreach ($active_pegawai as $pegawai) {
            $gajiLalu = $this->cek_gaji_bulan_lalu($pegawai->id, $periode_lalu);
            $gaji = $gajiLalu && $gajiLalu->gaji !== null ? $gajiLalu->gaji : 0;

            $dataGaji[] = [
                'id_pegawai' => $pegawai->id,
                'gaji' => $gaji,
                'created_by' => $this->session->userdata("fullname")
            ];

            foreach ($this->get_kategori_potongan() as $kategori) {
                $pot = $this->cek_pot_bulan_lalu($pegawai->id, $kategori->id, $periode_lalu);
                $dataPotongan[] = [
                    'id_pegawai' => $pegawai->id,
                    'id_potongan' => $kategori->id,
                    'potongan' => $pot ? $pot->potongan : 0,
                    'created_by' => $this->session->userdata("fullname")
                ];
            }
        }

        $this->insert_gaji($dataGaji);
        $this->insert_potongan($dataPotongan);

        return ['status' => 'sukses'];
    }

    public function insert_gaji($data)
    {
        if ($this->db->insert_batch('register_gaji', $data)) {
            return true;
        } else {
            // Log error or get the error message
            $error = $this->db->error();
            return false;
        }
    }

    public function insert_potongan($data)
    {
        if ($this->db->insert_batch('register_potongan_gaji', $data)) {
            return true;
        } else {
            // Log error or get the error message
            $error = $this->db->error();
            return false;
        }
    }

    public function cekPeriode($bulan)
    {
        $this->db->select('*');
        $this->db->like('created_on', $bulan);
        $query = $this->db->get('register_gaji');
        return $query->result();
    }

    public function cek_gaji_bulan_lalu($id, $bulan)
    {
        $this->db->select('*');
        $this->db->where("id_pegawai", $id);
        $this->db->like('created_on', $bulan);
        return $this->db->get('register_gaji')->row();
    }

    public function get_data_peran()
    {
        $this->db->select('l.id AS id, u.userid AS userid, u.fullname AS nama, l.role AS peran, l.hapus AS hapus');
        $this->db->from('peran l');
        $this->db->join($this->db_sso . '.v_users u', 'l.userid = u.userid', 'left');
        $this->db->order_by('l.id', 'ASC');
        $query = $this->db->get();

        return $query->result();
    }

    public function get_all_months()
    {
        $this->db->select('DATE_FORMAT(created_on, "%Y-%m") as month');
        $this->db->group_by('month');
        $this->db->order_by('month', 'DESC');
        return $this->db->get('register_gaji')->result_array();
    }

    public function get_pegawai_count_by_month($month)
    {
        $this->db->select('COUNT(DISTINCT id_pegawai) as pegawai_count');
        $this->db->where("DATE_FORMAT(created_on, '%Y-%m') = '" . $month . "'");
        return $this->db->get('register_gaji')->row()->pegawai_count;
    }

    public function cek_kategori($id)
    {
        try {
            $this->db->where('id_potongan', $id);
            return $this->db->get('register_potongan_gaji')->row();
        } catch (Exception $e) {
            return $e;
        }
    }

    public function hapus_kategori($id)
    {
        $table = 'ref_potongan';
        try {
            $this->db->where("id", $id);
            $this->db->delete($table);
            return 1;
        } catch (Exception $e) {
            return $e;
        }
    }

    public function get_seleksi($tabel, $kolom_seleksi, $seleksi)
    {
        try {
            $this->db->where($kolom_seleksi, $seleksi);
            return $this->db->get($tabel);
        } catch (Exception $e) {
            return 0;
        }
    }

    public function get_seleksi2($tabel, $kolom_seleksi, $seleksi, $kolom_seleksi2, $seleksi2)
    {
        try {
            $this->db->where($kolom_seleksi2, $seleksi2);
            $this->db->where($kolom_seleksi, $seleksi);
            return $this->db->get($tabel);
        } catch (Exception $e) {
            return 0;
        }
    }

    public function simpan_data($tabel, $data)
    {
        try {
            $this->db->insert($tabel, $data);
            $title = "Tambah Data <br />Insert tabel <b>" . $tabel;
            $descrip = null;
            $this->add_audittrail("INSERT", $title, $tabel, $descrip);
            return 1;
        } catch (Exception $e) {
            return 0;
        }
    }

    public function pembaharuan_data($tabel, $data, $kolom_seleksi, $seleksi)
    {
        try {
            $this->db->where($kolom_seleksi, $seleksi);
            $this->db->update($tabel, $data);
            $title = "Pembaharuan Data <br />Update tabel <b>" . $tabel . "</b>[Pada kolom<b>" . $kolom_seleksi . "</b>]";
            $descrip = null;
            $this->add_audittrail("UPDATE", $title, $tabel, $descrip);
            return 1;
        } catch (Exception $e) {
            return 0;
        }
    }

    public function ubah_status_peran($id, $status)
    {
        $data = [
            'hapus' => $status,
            'modified_by' => $this->session->userdata('username'),
            'modified_on' => date('Y-m-d H:i:s')
        ];

        return $this->pembaharuan_data('peran', $data, 'id', $id) === '1';
    }
}