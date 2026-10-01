<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Promosi extends CI_Controller {
    private $api_url = 'http://localhost:3000/api/promosi'; // URL Web Service Node.js

    public function __construct() {
        parent::__construct();
        $this->load->library(['form_validation', 'upload', 'session']);
        $this->load->helper('url');
    }

    // Menampilkan semua Promosi
    public function index() {
        // Check if the user is logged in
        if (!$this->session->userdata('user')) {
            redirect('auth/form_login'); // Redirect to login if not logged in
        }
    
        // Get user data from session
        $data['user'] = $this->session->userdata('user');
    
        // Get users data from API
        $json_data = @file_get_contents($this->api_url);
    
        if ($json_data === FALSE) {
            $data['promosi'] = [];
            $this->session->set_flashdata('error', 'Gagal mengambil data dari API.');
        } else {
            $users = json_decode($json_data, true);
            $data['promosi'] = $users;
        }
    
        // Load the view and pass the data
        $this->load->view('admin/promosi', $data);
    }

    public function index1() {
        // Check if the user is logged in
        if (!$this->session->userdata('user')) {
            redirect('auth/form_login');
        }
    
        // Get user data from session
        $data['user'] = $this->session->userdata('user');
        $username = $data['user']['username']; // Ambil username untuk filter
    
        // Initialize cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
    
        if (curl_errno($ch)) {
            $data['promosi'] = [];
            $this->session->set_flashdata('error', 'Gagal mengambil data dari API: ' . curl_error($ch));
        } else {
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($http_code == 200) {
                $promosi_data = json_decode($response, true);
                if (is_array($promosi_data)) {
                    // Filter promosi berdasarkan user yang login
                    $data['promosi'] = array_filter($promosi_data, function($promosi) use ($username) {
                        return isset($promosi['username']) && $promosi['username'] == $username;
                    });
                } else {
                    $data['promosi'] = [];
                    $this->session->set_flashdata('error', 'Format data dari API tidak valid.');
                }
            } else {
                $data['promosi'] = [];
                $this->session->set_flashdata('error', 'API mengembalikan kode status ' . $http_code);
            }
        }
    
        curl_close($ch);
    
        // Load the view and pass the data
        $this->load->view('admin/promosi1', $data);
    }
    


    // Menampilkan form untuk menambah Promosi
    public function create() {
        // Check if the user is logged in
        if (!$this->session->userdata('user')) {
            redirect('auth/form_login'); // Redirect to login if not logged in
        }
    
        // Initialize cURL to fetch users from the Node.js API
        $ch = curl_init('http://localhost:3000/api/users'); // Ganti endpoint untuk ambil user
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
        // Execute cURL request
        $response = curl_exec($ch);
    
        // Check for cURL errors
        if (curl_errno($ch)) {
            log_message('error', 'cURL Error: ' . curl_error($ch));
            $this->session->set_flashdata('error', 'Gagal mengambil data pengguna dari API.');
            $data['users'] = [];
        } else {
            curl_close($ch);
    
            // Decode JSON response
            $users = json_decode($response, true);
    
            // Check if user data exists
            if (isset($users) && is_array($users) && count($users) > 0) {
                $data['users'] = $users;
            } else {
                $data['users'] = [];
                $this->session->set_flashdata('error', 'Tidak ada user yang terdaftar.');
            }
        }
    
        // Get user data from session
        $data['user'] = $this->session->userdata('user');
    
        // Load the view and pass the data
        $this->load->view('admin/create_promosi', $data);
    }

      // Menampilkan form untuk menambah user
      public function create1() {
        // Check if the user is logged in
        if (!$this->session->userdata('user')) {
            redirect('auth/form_login'); // Redirect to login if not logged in
        }
    
        // Initialize cURL to fetch users from the Node.js API
        $ch = curl_init('http://localhost:3000/api/users'); // Ganti endpoint untuk ambil user
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
        // Execute cURL request
        $response = curl_exec($ch);
    
        // Check for cURL errors
        if (curl_errno($ch)) {
            log_message('error', 'cURL Error: ' . curl_error($ch));
            $this->session->set_flashdata('error', 'Gagal mengambil data pengguna dari API.');
            $data['users'] = [];
        } else {
            curl_close($ch);
    
            // Decode JSON response
            $users = json_decode($response, true);
    
            // Check if user data exists
            if (isset($users) && is_array($users) && count($users) > 0) {
                $data['users'] = $users;
            } else {
                $data['users'] = [];
                $this->session->set_flashdata('error', 'Tidak ada user yang terdaftar.');
            }
        }
    
        // Get user data from session
        $data['user'] = $this->session->userdata('user');
    
        // Load the view and pass the data
        $this->load->view('admin/create_promosi1', $data);
    }

    // Menyimpan data promosi baru
    public function store() {
        // Form validation rules
        $this->form_validation->set_rules('username', 'Username', 'required|alpha_numeric');
        $this->form_validation->set_rules('fasilitasi_promosi', 'Fasilitasi Promosi', 'required');
        $this->form_validation->set_rules('hambatan_memasarkan_produk', 'Hambatan Memasarkan Produk', 'required');
        $this->form_validation->set_rules('bantuan_dibutuhkan', 'Bantuan Dibutuhkan', 'required');
        $this->form_validation->set_rules('berminat_bazar_ramadhan', 'Berminat Bazar Ramadhan', 'required');
        $this->form_validation->set_rules('berminat_pelatihan_online', 'Berminat Pelatihan Online', 'required');
    
        // Check if form validation fails
        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('promosi');
            return;
        }
    
        // Prepare data to send to API
        $data = [
            'username' => $this->input->post('username'),
            'fasilitasi_promosi' => $this->input->post('fasilitasi_promosi'),
            'hambatan_memasarkan_produk' => $this->input->post('hambatan_memasarkan_produk'),
            'bantuan_dibutuhkan' => $this->input->post('bantuan_dibutuhkan'),
            'berminat_bazar_ramadhan' => $this->input->post('berminat_bazar_ramadhan'),
            'berminat_pelatihan_online' => $this->input->post('berminat_pelatihan_online')
        ];
    
        // Send data to API
        try {
            $response = $this->curl_post($this->api_url, $data);
    
            // Check if the response indicates success
            if (isset($response['success']) && $response['success']) {
                $this->session->set_flashdata('message', 'Data promosi berhasil disimpan.');
                redirect('promosi');
            } else {
                // Handle error from backend API response
                if (isset($response['error'])) {
                    // Specific error messages
                    switch ($response['error']) {
                        case 'Username not found':
                            $this->session->set_flashdata('error', 'Username tidak terdaftar di sistem.');
                            break;
                        case 'Promosi for this username already exists':
                            $this->session->set_flashdata('error', 'Promosi untuk username ini sudah ada.');
                            break;
                        case 'UMKM status is not approved (disetujui)':
                            $this->session->set_flashdata('error', 'Status UMKM tidak disetujui.');
                            break;
                        default:
                            $this->session->set_flashdata('error', 'Gagal menyimpan data promosi: ' . $response['error']);
                            break;
                    }
                } else {
                    $this->session->set_flashdata('error', 'Gagal menyimpan data promosi. Periksa kembali data Anda.');
                }
                redirect('promosi');
            }
        } catch (Exception $e) {
            $this->session->set_flashdata('error', 'Gagal menghubungi server, coba lagi nanti.');
            redirect('promosi');
        }
    }
    

 // Menyimpan data promosi baru
 public function store1() {
    // Form validation rules
    $this->form_validation->set_rules('username', 'Username', 'required|alpha_numeric');
    $this->form_validation->set_rules('fasilitasi_promosi', 'Fasilitasi Promosi', 'required');
    $this->form_validation->set_rules('hambatan_memasarkan_produk', 'Hambatan Memasarkan Produk', 'required');
    $this->form_validation->set_rules('bantuan_dibutuhkan', 'Bantuan Dibutuhkan', 'required');
    $this->form_validation->set_rules('berminat_bazar_ramadhan', 'Berminat Bazar Ramadhan', 'required');
    $this->form_validation->set_rules('berminat_pelatihan_online', 'Berminat Pelatihan Online', 'required');

    // Check if form validation fails
    if ($this->form_validation->run() === FALSE) {
        $this->session->set_flashdata('error', validation_errors());
        redirect('promosi1');
        return;
    }

    // Prepare data to send to the API
    $data = [
        'username' => $this->input->post('username'),
        'fasilitasi_promosi' => $this->input->post('fasilitasi_promosi'),
        'hambatan_memasarkan_produk' => $this->input->post('hambatan_memasarkan_produk'),
        'bantuan_dibutuhkan' => $this->input->post('bantuan_dibutuhkan'),
        'berminat_bazar_ramadhan' => $this->input->post('berminat_bazar_ramadhan'),
        'berminat_pelatihan_online' => $this->input->post('berminat_pelatihan_online')
    ];

    // Send data to the API
    try {
        $response = $this->curl_post($this->api_url, $data);

        // Check if the response indicates success
        if (isset($response['success']) && $response['success']) {
            $this->session->set_flashdata('message', 'Data promosi berhasil disimpan.');
            redirect('promosi1');
        } else {
            // Handle error from backend API response
            if (isset($response['error'])) {
                switch ($response['error']) {
                    case 'Username not found':
                        $this->session->set_flashdata('error', 'Username tidak terdaftar di sistem.');
                        break;
                    case 'Promosi for this username already exists':
                        $this->session->set_flashdata('error', 'Promosi untuk username ini sudah ada.');
                        break;
                    case 'UMKM status is not approved (disetujui)':
                        $this->session->set_flashdata('error', 'Status UMKM tidak disetujui.');
                        break;
                    default:
                        $this->session->set_flashdata('error', 'Gagal menyimpan data promosi: ' . $response['error']);
                        break;
                }
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan data promosi. Periksa kembali data Anda.');
            }
            redirect('promosi1');
        }
    } catch (Exception $e) {
        $this->session->set_flashdata('error', 'Gagal menghubungi server, coba lagi nanti.');
        redirect('promosi1');
    }
}



// Fungsi CURL POST
private function curl_post($url, $data) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Accept: application/json'
    ]);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        curl_close($ch);
        throw new Exception('Terjadi kesalahan saat menghubungi API.');
    }

    curl_close($ch);
    return json_decode($response, true);
}
    // Menampilkan form edit promosi
    public function edit($id) {
        if (!$this->session->userdata('user')) {
            redirect('auth/form_login');
        }
    
        // Ambil data promosi dari API berdasarkan username
        $ch = curl_init($this->api_url . '/' . $id);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
    
        if (curl_errno($ch)) {
            log_message('error', 'cURL Error: ' . curl_error($ch));
            $this->session->set_flashdata('error', 'Gagal mengambil data promosi dari API.');
            redirect('promosi');
        }
    
        curl_close($ch);
        $promosi = json_decode($response, true);
    
        if (!$promosi || isset($promosi['error'])) {
            $this->session->set_flashdata('error', 'Data promosi tidak ditemukan.');
            redirect('promosi');
        }
    
        $data['user'] = $this->session->userdata('user');
        $data['promosi'] = $promosi;
    
        // Load form edit view
        $this->load->view('admin/edit_promosi', $data);
    }
    // Update data promosi
public function update($id) {
    if (!$this->session->userdata('user')) {
        redirect('auth/form_login');
    }

    // Ambil data dari form
    $postData = array(
        'fasilitasi_promosi' => $this->input->post('fasilitasi_promosi'),
        'hambatan_memasarkan_produk' => $this->input->post('hambatan_memasarkan_produk'),
        'bantuan_dibutuhkan' => $this->input->post('bantuan_dibutuhkan'),
        'berminat_bazar_ramadhan' => $this->input->post('berminat_bazar_ramadhan'),
        'berminat_pelatihan_online' => $this->input->post('berminat_pelatihan_online')
    );

    // Inisialisasi cURL untuk request PUT ke API
    $ch = curl_init($this->api_url . '/' . $id);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        log_message('error', 'cURL Error: ' . curl_error($ch));
        $this->session->set_flashdata('error', 'Gagal memperbarui data promosi.');
        redirect('promosi');
    }

    curl_close($ch);
    $result = json_decode($response, true);

    if (isset($result['success']) && $result['success']) {
        $this->session->set_flashdata('success', 'Data promosi berhasil diperbarui.');
    } else {
        $errorMsg = isset($result['error']) ? $result['error'] : 'Terjadi kesalahan saat memperbarui data.';
        $this->session->set_flashdata('error', $errorMsg);
    }

    redirect('promosi');
}

    // Menampilkan form edit promosi
    public function edit1($username) {
        if (!$this->session->userdata('user')) {
            redirect('auth/form_login');
        }
    
        // Ambil data promosi dari API berdasarkan username
        $ch = curl_init($this->api_url . '/' . $username);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
    
        if (curl_errno($ch)) {
            log_message('error', 'cURL Error: ' . curl_error($ch));
            $this->session->set_flashdata('error', 'Gagal mengambil data promosi dari API.');
            redirect('promosi1');
        }
    
        curl_close($ch);
        $promosi = json_decode($response, true);
    
        if (!$promosi || isset($promosi['error'])) {
            $this->session->set_flashdata('error', 'Data promosi tidak ditemukan.');
            redirect('promosi1');
        }
    
        $data['user'] = $this->session->userdata('user');
        $data['promosi'] = $promosi;
    
        // Load form edit view
        $this->load->view('admin/edit_promosi1', $data);
    }
    // Update data promosi
public function update1($id) {
    if (!$this->session->userdata('user')) {
        redirect('auth/form_login');
    }

    // Ambil data dari form
    $postData = array(
        'fasilitasi_promosi' => $this->input->post('fasilitasi_promosi'),
        'hambatan_memasarkan_produk' => $this->input->post('hambatan_memasarkan_produk'),
        'bantuan_dibutuhkan' => $this->input->post('bantuan_dibutuhkan'),
        'berminat_bazar_ramadhan' => $this->input->post('berminat_bazar_ramadhan'),
        'berminat_pelatihan_online' => $this->input->post('berminat_pelatihan_online')
    );

    // Inisialisasi cURL untuk request PUT ke API
    $ch = curl_init($this->api_url . '/' . $id);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        log_message('error', 'cURL Error: ' . curl_error($ch));
        $this->session->set_flashdata('error', 'Gagal memperbarui data promosi.');
        redirect('promosi1');
    }

    curl_close($ch);
    $result = json_decode($response, true);

    if (isset($result['success']) && $result['success']) {
        $this->session->set_flashdata('success', 'Data promosi berhasil diperbarui.');
    } else {
        $errorMsg = isset($result['error']) ? $result['error'] : 'Terjadi kesalahan saat memperbarui data.';
        $this->session->set_flashdata('error', $errorMsg);
    }

    redirect('promosi1');
}
    

    public function delete($id) {
        if (!$this->session->userdata('user')) {
            redirect('auth/form_login');
        }
    
        // Kirim permintaan DELETE ke API
        $ch = curl_init($this->api_url . '/' . $id);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json'
        ]);
    
        $response = curl_exec($ch);
    
        if (curl_errno($ch)) {
            log_message('error', 'cURL Error: ' . curl_error($ch));
            $this->session->set_flashdata('error', 'Gagal menghapus data promosi.');
            redirect('promosi');
        }
    
        curl_close($ch);
        $result = json_decode($response, true);
    
        if (isset($result['success']) && $result['success']) {
            $this->session->set_flashdata('message', 'Data promosi berhasil dihapus.');
        } else {
            $error_message = isset($result['error']) ? $result['error'] : 'Terjadi kesalahan saat menghapus data.';
            $this->session->set_flashdata('error', 'Gagal menghapus data promosi: ' . $error_message);
        }
    
        redirect('promosi');
    }

    public function delete1($id) {
        if (!$this->session->userdata('user')) {
            redirect('auth/form_login');
        }
    
        // Kirim permintaan DELETE ke API
        $ch = curl_init($this->api_url . '/' . $id);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json'
        ]);
    
        $response = curl_exec($ch);
    
        if (curl_errno($ch)) {
            log_message('error', 'cURL Error: ' . curl_error($ch));
            $this->session->set_flashdata('error', 'Gagal menghapus data promosi.');
            redirect('promosi1');
        }
    
        curl_close($ch);
        $result = json_decode($response, true);
    
        if (isset($result['success']) && $result['success']) {
            $this->session->set_flashdata('message', 'Data promosi berhasil dihapus.');
        } else {
            $error_message = isset($result['error']) ? $result['error'] : 'Terjadi kesalahan saat menghapus data.';
            $this->session->set_flashdata('error', 'Gagal menghapus data promosi: ' . $error_message);
        }
    
        redirect('promosi1');
    }
    
}