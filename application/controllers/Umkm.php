<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Umkm extends CI_Controller {

    private $api_url = 'http://localhost:3000/api'; // URL Web Service Node.js

    public function __construct() {
        parent::__construct();
        $this->load->library(['form_validation', 'upload', 'session']);  // Pastikan 'upload' sudah diload
        $this->load->helper('url');
    }
    
    public function create() {
        // Check if the user is logged in
        if (!$this->session->userdata('user')) {
            redirect('auth/form_login'); // Redirect to login if not logged in
        }
    
        // Get user data from session
        $data['user'] = $this->session->userdata('user');
    
        // Load the create_umkm view and pass the session data
        $this->load->view('admin/create_umkm', $data);
    }

    public function create1() {
        // Check if the user is logged in
        if (!$this->session->userdata('user')) {
            redirect('auth/form_login'); // Redirect to login if not logged in
        }
    
        // Get user data from session
        $data['user'] = $this->session->userdata('user');
    
        // Load the create_umkm view and pass the session data
        $this->load->view('admin/create_umkm1', $data);
    }
    
    // Menampilkan Data UMKM dengan Status Menunggu
    public function menunggu() {
        // Check if the user is logged in
        if (!$this->session->userdata('user')) {
            redirect('auth/form_login'); // Redirect to login if not logged in
        }
    
        // Get user data from session
        $data['user'] = $this->session->userdata('user');
    
        // Perform the API call to get UMKM with status "menunggu"
        $ch = curl_init($this->api_url . '/umkm/status/menunggu');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $this->session->userdata('token')
        ]);
    
        $response = curl_exec($ch);
        curl_close($ch);
    
        $umkm = json_decode($response, true);
    
        // Check if UMKM data is available
        $data['umkm'] = isset($umkm) && is_array($umkm) && count($umkm) > 0 ? $umkm : null;
    
        // Load the view and pass the data
        $this->load->view('admin/menunggu', $data);
    }
    public function data_umkm() {
        // Check if the user is logged in
        if (!$this->session->userdata('user')) {
            redirect('auth/form_login'); // Redirect to login if not logged in
        }
    
        // Get user data from session
        $data['user'] = $this->session->userdata('user');
    
        // Get the logged-in user's username
        $username = $data['user']['username'];
    
        // Perform the API call to get UMKM data for the logged-in user
        $ch = curl_init($this->api_url . '/umkm/user/' . $username);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $this->session->userdata('token')
        ]);
    
        $response = curl_exec($ch);
        curl_close($ch);
    
        $umkm = json_decode($response, true);
    
        // Check if UMKM data is available
        $data['umkm'] = isset($umkm) && is_array($umkm) && count($umkm) > 0 ? $umkm : null;
    
        // Load the view and pass the data
        $this->load->view('admin/data_umkm', $data);
    }
    public function disetujui() {
        // Check if the user is logged in
        if (!$this->session->userdata('user')) {
            redirect('auth/form_login'); // Redirect to login if not logged in
        }
    
        // Get user data from session
        $data['user'] = $this->session->userdata('user');
    
        // Load pagination library
        $this->load->library('pagination');
    
        // Set the base URL for pagination
        $config['base_url'] = site_url('admin/disetujui');
    
        // Get the total number of UMKM with status "disetujui" (for pagination)
        $ch = curl_init($this->api_url . '/umkm/status/disetujui/count');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $this->session->userdata('token')
        ]);
        $count_response = curl_exec($ch);
        curl_close($ch);
    
        $count_data = json_decode($count_response, true);
        $total_rows = isset($count_data['total']) ? $count_data['total'] : 0;
    
        // Pagination settings
        $config['total_rows'] = $total_rows;
        $config['per_page'] = 5;
        $config['uri_segment'] = 3;
    
        // Initialize pagination
        $this->pagination->initialize($config);
    
        // Get the current page from the URL
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
    
        // Perform the API call to get UMKM with status "disetujui"
        $ch = curl_init($this->api_url . '/umkm/status/disetujui?page=' . ($page / $config['per_page'] + 1) . '&limit=' . $config['per_page']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $this->session->userdata('token')
        ]);
    
        $response = curl_exec($ch);
        curl_close($ch);
    
        $umkm = json_decode($response, true);
    
        // Check if UMKM data is available
        $data['umkm'] = isset($umkm) && is_array($umkm) && count($umkm) > 0 ? $umkm : null;
    
        // Add pagination links to the data
        $data['pagination'] = $this->pagination->create_links();
    
        // Load the view and pass the data
        $this->load->view('admin/disetujui', $data);
    }
    public function ditolak() {
        // Check if the user is logged in
        if (!$this->session->userdata('user')) {
            redirect('auth/form_login'); // Redirect to login if not logged in
        }
    
        // Get user data from session
        $data['user'] = $this->session->userdata('user');
    
        // Perform the API call to get UMKM with status "ditolak"
        $ch = curl_init($this->api_url . '/umkm/status/ditolak');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $this->session->userdata('token')
        ]);
    
        $response = curl_exec($ch);
        curl_close($ch);
    
        $umkm = json_decode($response, true);
    
        // Check if UMKM data is available
        $data['umkm'] = isset($umkm) && is_array($umkm) && count($umkm) > 0 ? $umkm : null;
    
        // Load the view and pass the data
        $this->load->view('admin/ditolak', $data);
    }
                
    

    // Menampilkan Form untuk Membuat UMKM Baru
    public function create_umkm() {
        // Initialize cURL to fetch users from the Node.js API
        $ch = curl_init($this->api_url . '/users');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
        // Execute the cURL request
        $response = curl_exec($ch);
    
        // Check if there was an error during the cURL request
        if (curl_errno($ch)) {
            // Log or handle the error here (e.g., show an error message)
            log_message('error', 'cURL Error: ' . curl_error($ch));
            $this->session->set_flashdata('error', 'Gagal mengambil data pengguna dari API.');
            $data['users'] = [];
        } else {
            // Close the cURL session
            curl_close($ch);
    
            // Decode the JSON response into an associative array
            $users = json_decode($response, true);
    
            // Check if the response contains valid user data
            if (isset($users) && is_array($users) && count($users) > 0) {
                $data['users'] = $users;  // Store users data
            } else {
                // If no users data is available
                $data['users'] = [];
                $this->session->set_flashdata('error', 'Tidak ada user yang terdaftar.');
            }
        }
    
        // Load the 'create_umkm' view and pass the users data
        $this->load->view('admin/create_umkm', $data);
    }
    
    
// Fungsi untuk Menyimpan UMKM Baru
public function store() {
    // Validasi Form
    $this->form_validation->set_rules('username', 'Username', 'required');
    $this->form_validation->set_rules('nama_usaha', 'Nama Usaha', 'required');
    $this->form_validation->set_rules('nama_merek_produk', 'Nama Merek Produk', 'required');
    $this->form_validation->set_rules('kategori_produk', 'Kategori Produk', 'required');
    $this->form_validation->set_rules('jalan', 'Jalan', 'required');
    $this->form_validation->set_rules('desa_kelurahan', 'Desa/Kelurahan', 'required');
    $this->form_validation->set_rules('kecamatan', 'Kecamatan', 'required');
    $this->form_validation->set_rules('jenis_usaha', 'jenis_usaha', 'required');
    $this->form_validation->set_rules('pendapatan', 'pendapatan', 'required');

    // Jika form tidak valid
    if ($this->form_validation->run() == FALSE) {
        $this->session->set_flashdata('error', validation_errors());
        redirect('umkm/create_umkm');
        return;
    }

    // Ambil username dari form
    $username = $this->input->post('username');

    // Cek apakah username sudah terdaftar
    $ch = curl_init($this->api_url . '/umkm/cek_username?username=' . urlencode($username));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $this->session->userdata('token')
    ]);

    $response = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($response, true);

    if (isset($result['error']) && $result['error'] == 'Username sudah terdaftar') {
        // Jika username sudah terdaftar, tampilkan pesan error
        $this->session->set_flashdata('error', 'Username sudah terdaftar. Silakan pilih username lain.');
        redirect('umkm/create_umkm');
        return;
    }

    // Ambil data dari form
    $whatsapp = $this->input->post('whatsapp');

    // Jika nomor WhatsApp diawali dengan '0', ganti dengan '62'
    if (!empty($whatsapp) && strpos($whatsapp, '0') === 0) {
        $whatsapp = '62' . substr($whatsapp, 1);
    }

    // Ambil data dari form lainnya
    $data = [
        'username'          => $this->input->post('username'),
        'nama_usaha'        => $this->input->post('nama_usaha'),
        'nama_merek_produk' => $this->input->post('nama_merek_produk'),
        'kategori_produk'   => $this->input->post('kategori_produk'),
        'jalan'             => $this->input->post('jalan'),
        'desa_kelurahan'    => $this->input->post('desa_kelurahan'),
        'kecamatan'         => $this->input->post('kecamatan'),
        'jenis_usaha'       => $this->input->post('jenis_usaha'),
        'pendapatan'        => $this->input->post('pendapatan'),
        'nib'               => $this->input->post('nib') ?: null,
        'pirt'              => $this->input->post('pirt') ?: null,
        'bpom'              => $this->input->post('bpom') ?: null,
        'halal'             => $this->input->post('halal') ?: null,
        'haki'              => $this->input->post('haki') ?: null,
        'lainnya'           => $this->input->post('lainnya') ?: null,
        'online'            => $this->input->post('online') ? 'online' : null,
        'offline'           => $this->input->post('offline') ? 'offline' : null,
        'agen_reseller'     => $this->input->post('agen_reseller') ? 'agen_reseller' : null,
        'deskripsi_produk'  => $this->input->post('deskripsi_produk') ?: null,
        
        // Tambahan field platform dengan link ke masing-masing platform
        'whatsapp'          => !empty($whatsapp) ? 'https://wa.me/' . $whatsapp : null,
        'blibli'            => $this->input->post('blibli') ? 'https://www.blibli.com/user/' . $this->input->post('blibli') : null,
        'lazada'            => $this->input->post('lazada') ? 'https://www.lazada.co.id/shop/' . $this->input->post('lazada') : null,
        'shopee'            => $this->input->post('shopee') ? 'https://shopee.co.id/' . $this->input->post('shopee') : null,
        'tokopedia'         => $this->input->post('tokopedia') ? 'https://www.tokopedia.com/' . $this->input->post('tokopedia') : null,
        'facebook'          => $this->input->post('facebook') ? 'https://www.facebook.com/' . $this->input->post('facebook') : null,
        'instagram'         => $this->input->post('instagram') ? 'https://www.instagram.com/' . $this->input->post('instagram') : null,
        'tiktok'            => $this->input->post('tiktok') ? 'https://www.tiktok.com/@' . $this->input->post('tiktok') : null,
        'twitter'           => $this->input->post('twitter') ? 'https://www.x.com/' . $this->input->post('twitter') : null
    ];

    // Kirim data ke API Node.js untuk menyimpan UMKM
    $ch = curl_init($this->api_url . '/umkm');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $this->session->userdata('token'),
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data, JSON_UNESCAPED_SLASHES));

    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);

    // Cek apakah penyimpanan berhasil
    if (isset($result['success']) && $result['success']) {
        // Menampilkan notifikasi berhasil
        $this->session->set_flashdata('message', 'UMKM berhasil ditambahkan.');
    } else {
        // Cek apakah ada error dan apakah error terkait username yang sudah terdaftar
        if (isset($result['error']) && $result['error'] == 'Username sudah terdaftar') {
            // Menampilkan username dan status jika sudah terdaftar
            $username = $this->input->post('username');
            $status = isset($result['status']) ? $result['status'] : 'tidak diketahui';
            $this->session->set_flashdata('error', 'Username "' . $username . '" sudah terdaftar dengan status ' . $status . '. Silakan pilih username lain.');
        } else {
            // Menampilkan notifikasi gagal jika bukan masalah username
            $error_message = isset($result['error']) ? $result['error'] : json_encode($result);
            $this->session->set_flashdata('error', 'UMKM gagal ditambahkan: ' . 'Username sudah terdaftar');
        }
    }

    // Redirect ke halaman menunggu atau halaman lain sesuai kebutuhan
    redirect('umkm/menunggu');
}

public function store1() {
    // Validasi Form
    $this->form_validation->set_rules('username', 'Username', 'required');
    $this->form_validation->set_rules('nama_usaha', 'Nama Usaha', 'required');
    $this->form_validation->set_rules('nama_merek_produk', 'Nama Merek Produk', 'required');
    $this->form_validation->set_rules('kategori_produk', 'Kategori Produk', 'required');
    $this->form_validation->set_rules('jalan', 'Jalan', 'required');
    $this->form_validation->set_rules('desa_kelurahan', 'Desa/Kelurahan', 'required');
    $this->form_validation->set_rules('kecamatan', 'Kecamatan', 'required');
    $this->form_validation->set_rules('jenis_usaha', 'Jenis Usaha', 'required');
    $this->form_validation->set_rules('pendapatan', 'Pendapatan', 'required');

    // Jika form tidak valid
    if ($this->form_validation->run() == FALSE) {
        $this->session->set_flashdata('error', validation_errors());
        redirect('umkm/create_umkm1');
        return;
    }

    // Ambil data dari form
    $whatsapp = $this->input->post('whatsapp');

    // Jika nomor WhatsApp diawali dengan '0', ganti dengan '62'
    if (!empty($whatsapp) && strpos($whatsapp, '0') === 0) {
        $whatsapp = '62' . substr($whatsapp, 1);
    }

    // Ambil data dari form lainnya
    $data = [
        'username'          => $this->input->post('username'),
        'nama_usaha'        => $this->input->post('nama_usaha'),
        'nama_merek_produk' => $this->input->post('nama_merek_produk'),
        'kategori_produk'   => $this->input->post('kategori_produk'),
        'jalan'             => $this->input->post('jalan'),
        'desa_kelurahan'    => $this->input->post('desa_kelurahan'),
        'kecamatan'         => $this->input->post('kecamatan'),
        'jenis_usaha'       => $this->input->post('jenis_usaha'),
        'pendapatan'        => $this->input->post('pendapatan'),
        'nib'               => $this->input->post('nib') ?: null,
        'pirt'              => $this->input->post('pirt') ?: null,
        'bpom'              => $this->input->post('bpom') ?: null,
        'halal'             => $this->input->post('halal') ?: null,
        'haki'              => $this->input->post('haki') ?: null,
        'lainnya'           => $this->input->post('lainnya') ?: null,
        'online'            => $this->input->post('online') ? 'online' : null,
        'offline'           => $this->input->post('offline') ? 'offline' : null,
        'agen_reseller'     => $this->input->post('agen_reseller') ? 'agen_reseller' : null,
        'deskripsi_produk'  => $this->input->post('deskripsi_produk') ?: null,
        
        // Tambahan field platform dengan link ke masing-masing platform
        'whatsapp'          => !empty($whatsapp) ? 'https://wa.me/' . $whatsapp : null,
        'blibli'            => $this->input->post('blibli') ? 'https://www.blibli.com/user/' . $this->input->post('blibli') : null,
        'lazada'            => $this->input->post('lazada') ? 'https://www.lazada.co.id/shop/' . $this->input->post('lazada') : null,
        'shopee'            => $this->input->post('shopee') ? 'https://shopee.co.id/' . $this->input->post('shopee') : null,
        'tokopedia'         => $this->input->post('tokopedia') ? 'https://www.tokopedia.com/' . $this->input->post('tokopedia') : null,
        'facebook'          => $this->input->post('facebook') ? 'https://www.facebook.com/' . $this->input->post('facebook') : null,
        'instagram'         => $this->input->post('instagram') ? 'https://www.instagram.com/' . $this->input->post('instagram') : null,
        'tiktok'            => $this->input->post('tiktok') ? 'https://www.tiktok.com/@' . $this->input->post('tiktok') : null,
        'twitter'           => $this->input->post('twitter') ? 'https://www.x.com/' . $this->input->post('twitter') : null
    ];

    // Kirim data ke API Node.js untuk menyimpan UMKM
    $ch = curl_init($this->api_url . '/umkm');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $this->session->userdata('token'),
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data, JSON_UNESCAPED_SLASHES));

    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);

    // Cek apakah penyimpanan berhasil
    if (isset($result['success']) && $result['success']) {
        // Menampilkan notifikasi berhasil
        $this->session->set_flashdata('message', 'UMKM berhasil ditambahkan.');
    } else {
        // Menampilkan notifikasi gagal
        $error_message = isset($result['error']) ? $result['error'] : json_encode($result);
        $this->session->set_flashdata('error', 'UMKM gagal ditambahkan: ' . $error_message);
    }

    // Redirect ke halaman menunggu atau halaman lain sesuai kebutuhan
    redirect('umkm/data_umkm');
}

    // Display UMKM data for editing
    public function edit($id) {
        // Check if the user is logged in
        if (!$this->session->userdata('user')) {
            redirect('auth/form_login'); // Redirect to login if not logged in
        }
    
        // Get user data from session
        $data['user'] = $this->session->userdata('user');
    
        // Send a GET request to fetch the existing UMKM data by ID
        $ch = curl_init($this->api_url . '/umkm/' . $id);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $this->session->userdata('token')
        ]);
    
        $response = curl_exec($ch);
        curl_close($ch);
    
        $umkm = json_decode($response, true);
    
        // If the UMKM data is found, send it to the view
        if (isset($umkm) && is_array($umkm)) {
            $data['umkm'] = $umkm;
        } else {
            $data['umkm'] = null;
            $this->session->set_flashdata('error', 'UMKM data not found.');
        }
    
        // Load the edit view with the UMKM data and user session data
        $this->load->view('admin/edit_umkm', $data);
    }
    
    public function edit1($id) {
        // Check if the user is logged in
        if (!$this->session->userdata('user')) {
            redirect('auth/form_login'); // Redirect to login if not logged in
        }
    
        // Get user data from session
        $data['user'] = $this->session->userdata('user');
    
        // Send a GET request to fetch the existing UMKM data by ID
        $ch = curl_init($this->api_url . '/umkm/' . $id);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $this->session->userdata('token')
        ]);
    
        $response = curl_exec($ch);
        curl_close($ch);
    
        $umkm = json_decode($response, true);
    
        // If the UMKM data is found, send it to the view
        if (isset($umkm) && is_array($umkm)) {
            $data['umkm'] = $umkm;
        } else {
            $data['umkm'] = null;
            $this->session->set_flashdata('error', 'UMKM data not found.');
        }
    
        // Load the edit view with the UMKM data and user session data
        $this->load->view('admin/edit_umkm1', $data);
    }
// Fungsi untuk memperbarui data UMKM
public function update($id) {
    // Membuat folder upload jika belum ada
    $upload_path = './uploads/umkm/';
    if (!is_dir($upload_path)) {
        mkdir($upload_path, 0777, true);
    }
    // Konfigurasi upload file
    $config['upload_path'] = $upload_path;
    $config['allowed_types'] = 'jpg|jpeg|png';
    $config['max_size'] = 2048;  // Maksimal 2MB
    $config['file_ext_tolower'] = TRUE;
    $config['encrypt_name'] = TRUE;
    $this->upload->initialize($config);
    // Upload Photo (opsional)
    $photo = $this->input->post('old_photo') ?: 'default.png';  // Gunakan photo lama sebagai default
    if (!empty($_FILES['photo']['name'])) {
        if (!$this->upload->do_upload('photo')) {
            $error = $this->upload->display_errors();
            $this->session->set_flashdata('error', 'Photo upload failed: ' . $error);
            redirect('umkm/edit/' . $id);
            return;
        } else {
            $upload_data = $this->upload->data();
            $photo = $upload_data['file_name']; // Hanya simpan nama file saja

            // Hapus foto lama jika ada dan berbeda dari default.png
            $old_photo = $this->input->post('old_photo');
            if (!empty($old_photo) && $old_photo != 'default.png' && file_exists($upload_path . $old_photo)) {
                unlink($upload_path . $old_photo);
            }
        }
    }
    // Fungsi untuk memastikan URL memiliki prefix 'https://'
    function ensure_https($url, $prefix = '') {
        if (!empty($url)) {
            // Jika URL tidak mengandung 'http://' atau 'https://', tambahkan prefix
            if (!preg_match('/^https?:\/\//', $url)) {
                return $prefix . $url;
            }
        }
        return $url;
    }
    // Form validation rules
$this->form_validation->set_rules('username', 'Username', 'required');
$this->form_validation->set_rules('nama_usaha', 'Nama Usaha', 'required');
$this->form_validation->set_rules('nama_merek_produk', 'Nama Merek Produk', 'required');
$this->form_validation->set_rules('kategori_produk', 'Kategori Produk', 'required');
$this->form_validation->set_rules('jalan', 'Jalan', 'required');
$this->form_validation->set_rules('desa_kelurahan', 'Desa/Kelurahan', 'required');
$this->form_validation->set_rules('kecamatan', 'Kecamatan', 'required');
$this->form_validation->set_rules('jenis_usaha', 'Jenis Usaha', 'required');
$this->form_validation->set_rules('pendapatan', 'Pendapatan', 'required');
$this->form_validation->set_rules('status', 'Status', 'required');
// Validasi kolom sosial media dan marketplace
$this->form_validation->set_rules('whatsapp', 'WhatsApp', 'trim');
$this->form_validation->set_rules('blibli', 'Blibli', 'trim');
$this->form_validation->set_rules('lazada', 'Lazada', 'trim');
$this->form_validation->set_rules('shopee', 'Shopee', 'trim');
$this->form_validation->set_rules('tokopedia', 'Tokopedia', 'trim');
$this->form_validation->set_rules('facebook', 'Facebook', 'trim');
$this->form_validation->set_rules('instagram', 'Instagram', 'trim');
$this->form_validation->set_rules('tiktok', 'Tiktok', 'trim');
$this->form_validation->set_rules('twitter', 'Twitter', 'trim');
// Tidak perlu validasi catatan, karena itu opsional
$this->form_validation->set_rules('catatan', 'Catatan', 'trim');
// Validasi form
if ($this->form_validation->run() === FALSE) {
    $this->session->set_flashdata('error', validation_errors());
    redirect('umkm/edit/' . $id);
    return;
}
// Data untuk dikirim ke API
$data = [
    'username'            => $this->input->post('username', TRUE),
    'nama_usaha'          => $this->input->post('nama_usaha', TRUE),
    'nama_merek_produk'   => $this->input->post('nama_merek_produk', TRUE),
    'kategori_produk'     => $this->input->post('kategori_produk', TRUE),
    'jalan'               => $this->input->post('jalan', TRUE),
    'desa_kelurahan'      => $this->input->post('desa_kelurahan', TRUE),
    'kecamatan'           => $this->input->post('kecamatan', TRUE),
    'jenis_usaha'         => $this->input->post('jenis_usaha', TRUE),
    'pendapatan'         => $this->input->post('pendapatan', TRUE),
    'nib'                 => $this->input->post('nib') ?: null,
    'pirt'                => $this->input->post('pirt') ?: null,
    'bpom'                => $this->input->post('bpom') ?: null,
    'halal'               => $this->input->post('halal') ?: null,
    'haki'                => $this->input->post('haki') ?: null,
    'lainnya'             => $this->input->post('lainnya') ?: null,
    'online'              => $this->input->post('online') ? 'online' : null,
    'offline'             => $this->input->post('offline') ? 'offline' : null,
    'agen_reseller'       => $this->input->post('agen_reseller') ? 'agen_reseller' : null,
    'deskripsi_produk'    => $this->input->post('deskripsi_produk') ?: null,
    'status'              => $this->input->post('status'),
    'photo'               => $photo,
    'whatsapp'            => !empty($this->input->post('whatsapp')) ? ensure_https($this->input->post('whatsapp'), 'https://wa.me/') : null,
    'blibli'              => !empty($this->input->post('blibli')) ? ensure_https($this->input->post('blibli'), 'https://www.blibli.com/user/') : null,
    'lazada'              => !empty($this->input->post('lazada')) ? ensure_https($this->input->post('lazada'), 'https://www.lazada.co.id/shop/') : null,
    'shopee'              => !empty($this->input->post('shopee')) ? ensure_https($this->input->post('shopee'), 'https://shopee.co.id/') : null,
    'tokopedia'           => !empty($this->input->post('tokopedia')) ? ensure_https($this->input->post('tokopedia'), 'https://www.tokopedia.com/') : null,
    'facebook'            => !empty($this->input->post('facebook')) ? ensure_https($this->input->post('facebook'), 'https://www.facebook.com/') : null,
    'instagram'           => !empty($this->input->post('instagram')) ? ensure_https($this->input->post('instagram'), 'https://www.instagram.com/') : null,
    'tiktok'              => !empty($this->input->post('tiktok')) ? ensure_https($this->input->post('tiktok'), 'https://www.tiktok.com/@') : null,
    'twitter'             => !empty($this->input->post('twitter')) ? ensure_https($this->input->post('twitter'), 'https://www.x.com/') : null,
    'catatan'             => !empty($this->input->post('catatan')) ? $this->input->post('catatan') : (isset($umkm['catatan']) ? $umkm['catatan'] : '-'), // Ensure catatan is preserved
];
// URL untuk PUT request
$url = $this->api_url . '/umkm/' . $id;
// Kirim data ke API menggunakan CURL
try {
    $response = $this->curl_put($url, $data);

    if (isset($response['success']) && $response['success']) {
        $this->session->set_flashdata('message', 'UMKM berhasil diperbarui.');
    } else {
        $error_message = isset($response['error']) ? $response['error'] : json_encode($response);
        $this->session->set_flashdata('error', $error_message);
    }
} catch (Exception $e) {
    $this->session->set_flashdata('error', 'Gagal memperbarui UMKM. Silahkan coba lagi.');
}
// Redirect ke halaman sesuai status
if ($data['status'] === 'disetujui') {
    redirect('umkm/disetujui');
} elseif ($data['status'] === 'ditolak') {
    redirect('umkm/ditolak');
} else {
    redirect('umkm/menunggu');
}
}

public function update1($id) {
    if (!$this->session->userdata('user')) {
        redirect('auth/form_login');
    }

    // Membuat folder upload jika belum ada
    $upload_path = './uploads/umkm/';
    if (!is_dir($upload_path)) {
        mkdir($upload_path, 0777, true);
    }

    // Konfigurasi upload file
    $config['upload_path'] = $upload_path;
    $config['allowed_types'] = 'jpg|jpeg|png';
    $config['max_size'] = 2048;  // Maksimal 2MB
    $config['file_ext_tolower'] = TRUE;
    $config['encrypt_name'] = TRUE;
    $this->upload->initialize($config);

    // Upload Photo (opsional)
    $photo = $this->input->post('old_photo') ?: 'default.png';  // Gunakan photo lama sebagai default
    if (!empty($_FILES['photo']['name'])) {
        if (!$this->upload->do_upload('photo')) {
            $error = $this->upload->display_errors();
            $this->session->set_flashdata('error', 'Photo upload failed: ' . $error);
            redirect('umkm/edit1/' . $id);
            return;
        } else {
            $upload_data = $this->upload->data();
            $photo = $upload_data['file_name']; // Hanya simpan nama file saja

            // Hapus foto lama jika ada dan berbeda dari default.png
            $old_photo = $this->input->post('old_photo');
            if (!empty($old_photo) && $old_photo != 'default.png' && file_exists($upload_path . $old_photo)) {
                unlink($upload_path . $old_photo);
            }
        }
    }

    // Fungsi untuk memastikan URL memiliki prefix 'https://'
    function ensure_https($url, $prefix = '') {
        if (!empty($url)) {
            // Jika URL tidak mengandung 'http://' atau 'https://', tambahkan prefix
            if (!preg_match('/^https?:\/\//', $url)) {
                return $prefix . $url;
            }
        }
        return $url;
    }

    // Form validation rules
    $this->form_validation->set_rules('username', 'Username', 'required');
    $this->form_validation->set_rules('nama_usaha', 'Nama Usaha', 'required');
    $this->form_validation->set_rules('nama_merek_produk', 'Nama Merek Produk', 'required');
    $this->form_validation->set_rules('kategori_produk', 'Kategori Produk', 'required');
    $this->form_validation->set_rules('jalan', 'Jalan', 'required');
    $this->form_validation->set_rules('desa_kelurahan', 'Desa/Kelurahan', 'required');
    $this->form_validation->set_rules('kecamatan', 'Kecamatan', 'required');
    $this->form_validation->set_rules('jenis_usaha', 'Jenis Usaha', 'required');
    $this->form_validation->set_rules('pendapatan', 'Pendapatan', 'required');
    $this->form_validation->set_rules('status', 'Status', 'required');

    // Validasi kolom sosial media dan marketplace
    $this->form_validation->set_rules('whatsapp', 'WhatsApp', 'trim');
    $this->form_validation->set_rules('blibli', 'Blibli', 'trim');
    $this->form_validation->set_rules('lazada', 'Lazada', 'trim');
    $this->form_validation->set_rules('shopee', 'Shopee', 'trim');
    $this->form_validation->set_rules('tokopedia', 'Tokopedia', 'trim');
    $this->form_validation->set_rules('facebook', 'Facebook', 'trim');
    $this->form_validation->set_rules('instagram', 'Instagram', 'trim');
    $this->form_validation->set_rules('tiktok', 'Tiktok', 'trim');
    $this->form_validation->set_rules('twitter', 'Twitter', 'trim');

    if ($this->form_validation->run() === FALSE) {
        $this->session->set_flashdata('error', validation_errors());
        redirect('umkm/edit/' . $id);
        return;
    }

    // Data untuk dikirim ke API
    $data = [
        'username'            => $this->input->post('username', TRUE),
        'nama_usaha'          => $this->input->post('nama_usaha', TRUE),
        'nama_merek_produk'   => $this->input->post('nama_merek_produk', TRUE),
        'kategori_produk'     => $this->input->post('kategori_produk', TRUE),
        'jalan'               => $this->input->post('jalan', TRUE),
        'desa_kelurahan'      => $this->input->post('desa_kelurahan', TRUE),
        'kecamatan'           => $this->input->post('kecamatan', TRUE),
        'jenis_usaha'         => $this->input->post('jenis_usaha', TRUE),
        'pendapatan'         => $this->input->post('pendapatan', TRUE),
        'nib'                 => $this->input->post('nib') ?: null,
        'pirt'                => $this->input->post('pirt') ?: null,
        'bpom'                => $this->input->post('bpom') ?: null,
        'halal'               => $this->input->post('halal') ?: null,
        'haki'                => $this->input->post('haki') ?: null,
        'lainnya'             => $this->input->post('lainnya') ?: null,
        'online'              => $this->input->post('online') ? 'online' : null,
        'offline'             => $this->input->post('offline') ? 'offline' : null,
        'agen_reseller'       => $this->input->post('agen_reseller') ? 'agen_reseller' : null,
        'deskripsi_produk'    => $this->input->post('deskripsi_produk') ?: null,
        'status'              => $this->input->post('status'),
        'photo'               => $photo,
        'whatsapp'            => !empty($this->input->post('whatsapp')) ? ensure_https($this->input->post('whatsapp'), 'https://wa.me/') : null,
        'blibli'              => !empty($this->input->post('blibli')) ? ensure_https($this->input->post('blibli'), 'https://www.blibli.com/user/') : null,
        'lazada'              => !empty($this->input->post('lazada')) ? ensure_https($this->input->post('lazada'), 'https://www.lazada.co.id/shop/') : null,
        'shopee'              => !empty($this->input->post('shopee')) ? ensure_https($this->input->post('shopee'), 'https://shopee.co.id/') : null,
        'tokopedia'           => !empty($this->input->post('tokopedia')) ? ensure_https($this->input->post('tokopedia'), 'https://www.tokopedia.com/') : null,
        'facebook'            => !empty($this->input->post('facebook')) ? ensure_https($this->input->post('facebook'), 'https://www.facebook.com/') : null,
        'instagram'           => !empty($this->input->post('instagram')) ? ensure_https($this->input->post('instagram'), 'https://www.instagram.com/') : null,
        'tiktok'              => !empty($this->input->post('tiktok')) ? ensure_https($this->input->post('tiktok'), 'https://www.tiktok.com/@') : null,
        'twitter'             => !empty($this->input->post('twitter')) ? ensure_https($this->input->post('twitter'), 'https://www.x.com/') : null
    ];

    // URL untuk PUT request
    $url = $this->api_url . '/umkm/' . $id;

    // Kirim data ke API menggunakan CURL
    try {
        $response = $this->curl_put($url, $data);

        if (isset($response['success']) && $response['success']) {
            $this->session->set_flashdata('message', 'UMKM berhasil diperbarui.');
        } else {
            $error_message = isset($response['error']) ? $response['error'] : json_encode($response);
            $this->session->set_flashdata('error', $error_message);
        }
    } catch (Exception $e) {
        $this->session->set_flashdata('error', 'Gagal memperbarui UMKM. Silahkan coba lagi.');
    }

    // Redirect ke halaman menunggu atau disetujui sesuai status
    redirect('umkm/data_umkm');
}

// Fungsi CURL PUT
private function curl_put($url, $data) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $this->session->userdata('token'),
        'Content-Type: application/json',
        'Accept: application/json'
    ]);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        curl_close($ch);
        throw new Exception('Error connecting to API.');
    }

    curl_close($ch);
    return json_decode($response, true);
}



// Fungsi untuk menghapus UMKM berdasarkan ID
public function delete($id) {
    // Membuat request ke API Node.js untuk menghapus UMKM
    $ch = curl_init($this->api_url . '/umkm/' . $id);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $this->session->userdata('token')
    ]);
    
    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);

    // Cek apakah penghapusan berhasil
    if (isset($result['success']) && $result['success']) {
        $this->session->set_flashdata('message', 'UMKM berhasil dihapus.');
    } else {
        $error_message = isset($result['error']) ? $result['error'] : json_encode($result);
        $this->session->set_flashdata('error', 'gagal menghapus UMKM: ' . $error_message);
    }

    // Redirect kembali ke halaman menunggu atau halaman lain sesuai kebutuhan
    redirect('umkm/menunggu');
}


public function deleteDisetujui($id) {
    // Membuat request ke API Node.js untuk menghapus UMKM yang sudah disetujui
    $ch = curl_init($this->api_url . '/umkm/' . $id);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $this->session->userdata('token')
    ]);
    
    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);

    // Cek apakah penghapusan berhasil
    if (isset($result['success']) && $result['success']) {
        $this->session->set_flashdata('message', 'UMKM berhasil dihapus.');
    } else {
        $error_message = isset($result['error']) ? $result['error'] : json_encode($result);
        $this->session->set_flashdata('error', 'gagal menghapus UMKM: ' . $error_message);
    }
    // Redirect kembali ke halaman menunggu atau halaman lain sesuai kebutuhan
    redirect('umkm/disetujui');
}
public function deleteDitolak($id) {
    // Membuat request ke API Node.js untuk menghapus UMKM yang sudah disetujui
    $ch = curl_init($this->api_url . '/umkm/' . $id);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $this->session->userdata('token')
    ]);
    
    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);

    // Cek apakah penghapusan berhasil
    if (isset($result['success']) && $result['success']) {
        $this->session->set_flashdata('message', 'UMKM berhasil dihapus.');
    } else {
        $error_message = isset($result['error']) ? $result['error'] : json_encode($result);
        $this->session->set_flashdata('error', 'gagal menghapus UMKM: ' . $error_message);
    }
    // Redirect kembali ke halaman menunggu atau halaman lain sesuai kebutuhan
    redirect('umkm/ditolak');
}


}