<?php

/**
 * @property CI_Config $config
 * @property CI_Input $input
 * @property CI_Model $model
 * @property CI_Model $api
 * @property CI_Encryption $encryption
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 */

class MY_Controller extends CI_Controller
{
    private $jwt_key;
    protected $peran;

    public function __construct()
    {
        parent::__construct();
        $this->jwt_key = $this->config->item('jwt_key'); // inisialisasi di sini
        $cookie_domain = $this->config->item('cookie_domain');
        $sso_server = $this->config->item('sso_server');
        $this->session->set_userdata('sso_db', $this->config->item('sso_db'));

        $this->load->model('ModelGaji', 'model');

        if (!$this->session->userdata('logged_in')) {
            $token = $this->input->cookie('sso_token');
            if ($token) {
                $this->cek_token($token);
            } else {
                $redirect_url = current_url();
                setcookie('redirect_to', urlencode($redirect_url), time() + 300, "/", $cookie_domain);
                redirect($sso_server . 'login');
            }
        }

        # Cek Data Aplikasi Ini
        $this->model->cek_aplikasi();

        # Periksa apakah user login sebagai plh/plt atau bukan
        $token = "plh/plt";
        if ($this->session->userdata('status_plh') == '0') {
            if ($this->session->userdata('status_plt') == '0') {
                $token = $this->model->get_token();
            }
        }

        #Cek peran pegawai
        if ($this->session->userdata('role') == 'validator_uk_satker') {
            $this->session->set_userdata('peran', 'validator');
        }
        
        $query = $this->model->get_seleksi2('peran', 'userid', $this->session->userdata('userid'), 'hapus', '0');
        if ($query->num_rows() > 0 || $this->session->userdata('super')) {
            $this->peran = 'admin';
        }

    }

    private function cek_token($token)
    {
        $cookie_domain = $this->config->item('sso_server');
        $sso_api = $cookie_domain . "api/cek_token?sso_token={$token}";
        $response = file_get_contents($sso_api);
        $data = json_decode($response, true);

        if ($data['status'] == 'success') {
            $this->session->set_userdata([
                'logged_in' => TRUE,
                'userid' => $data['user']['userid'],
                'status_plh' => $data['user']['status_plh'],
                'status_plt' => $data['user']['status_plt']
            ]);
            redirect(current_url());
        } else {
            redirect($cookie_domain . 'login');
        }
    }

    private function get_config_value($seleksi)
    {
        $params = [
            'tabel' => 'sys_config',
            'kolom_seleksi' => 'id',
            'seleksi' => $seleksi
        ];

        $result = $this->apihelper->get('apiclient/get_data_seleksi', $params);

        if ($result['status_code'] === 200 && $result['response']['status'] === 'success') {
            $user_data = $result['response']['data'][0];
            return $user_data['value'];
        }
    }
}