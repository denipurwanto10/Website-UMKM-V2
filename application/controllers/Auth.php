<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    private $api_url = 'http://localhost:3000/api'; // URL API Node.js

    public function __construct() {
        parent::__construct();
        $this->load->library(['form_validation', 'session']);
        $this->load->helper(['url', 'form']);
    }

    // Show the login form
    public function form_login() {
        $this->load->view('auth/form_login');
    }

    // Handle the login process
    public function login() {
        // Validasi form
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        // Menambahkan pesan kesalahan kustom
        $this->form_validation->set_message('required', 'Harap isi %s.');

        if ($this->form_validation->run() === FALSE) {
            // Jika validasi form gagal, reload form login dengan error
            $this->load->view('auth/form_login');
            return;
        }

        // Mengambil input
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        // Cek karakter mencurigakan dalam username atau password
        $pattern = "/(union|select|insert|update|delete|drop|--|#|'|\")/i";
        if (preg_match($pattern, $username) || preg_match($pattern, $password)) {
            // Jika ada input berbahaya, tampilkan pesan peringatan dan batalkan login
            $this->session->set_flashdata('error', 'Penggunaan input berbahaya terdeteksi! Akses ilegal tidak diperbolehkan.');
            redirect('auth/form_login');
            return;
        }

        // Jika aman, kirim request ke API
        $post_data = json_encode([
            'username' => $username,
            'password' => $password
        ]);

        // Inisialisasi CURL untuk melakukan request API
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->api_url . '/login');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);

        // Eksekusi request API
        $response = curl_exec($ch);

        // API mati / cURL error: beri pesan yang jelas
        if ($response === false || curl_errno($ch)) {
            $curl_err = curl_error($ch);
            log_message('error', 'Auth login cURL error: ' . $curl_err);
            curl_close($ch);
            $this->session->set_flashdata('error', 'Server autentikasi tidak dapat dihubungi. Pastikan API (localhost:3000) berjalan, lalu coba lagi.');
            redirect('auth/form_login');
            return;
        }
        curl_close($ch);

        // Decode response JSON dari Node.js
        $response_data = json_decode($response, true);

        if (!is_array($response_data)) {
            log_message('error', 'Auth login invalid JSON response.');
            $this->session->set_flashdata('error', 'Respons server tidak valid. Silakan coba lagi.');
            redirect('auth/form_login');
            return;
        }

        // Menangani response dan memberikan pesan yang sesuai
        if (isset($response_data['success']) && $response_data['success'] == true) {
            // Login berhasil
            $this->session->set_userdata('user', $response_data['user']);
            $this->session->set_userdata('token', isset($response_data['token']) ? $response_data['token'] : null);

            // Set success message
            $this->session->set_flashdata('success', 'Login berhasil!');
            redirect('dashboard');
        } else {
            // Set error message
            $this->session->set_flashdata('error', isset($response_data['message']) ? $response_data['message'] : 'Login gagal. Silakan coba lagi.');
            redirect('auth/form_login');
        }
    }

    public function all()
    {
        // Get the selected filters from the request (if any)
        $category_filter = $this->input->get('category');
        $business_name_filter = $this->input->get('nama_usaha');
        $brand_name_filter = $this->input->get('nama_merek_produk');

        // Define the API URL
        $api_url = 'http://localhost:3000/api/umkm/status/disetujui';

        // Fetch the data from the API (guarded: API mati -> array kosong)
        $response = $this->curl_request($api_url);
        if ($response === false) {
            log_message('error', 'Auth all(): API request failed.');
            $this->session->set_flashdata('error', 'Gagal mengambil data UMKM dari server.');
            $data['umkm'] = [];
            $this->load->view('all', $data);
            return;
        }

        $umkm_data = json_decode($response, true);
        if (!is_array($umkm_data)) {
            log_message('error', 'Auth all(): JSON decode error: ' . json_last_error_msg());
            $data['umkm'] = [];
            $this->load->view('all', $data);
            return;
        }

        // Filter the UMKM data based on category, business name, and brand name if filters are applied
        $umkm_data = array_values(array_filter($umkm_data, function ($item) use ($category_filter, $business_name_filter, $brand_name_filter) {
            $match = true;

            // Filter by category if provided
            if ($category_filter) {
                $match = $match && strtolower(isset($item['kategori_produk']) ? $item['kategori_produk'] : '') == strtolower($category_filter);
            }

            // Filter by business name if provided
            if ($business_name_filter) {
                $match = $match && strpos(strtolower(isset($item['nama_usaha']) ? $item['nama_usaha'] : ''), strtolower($business_name_filter)) !== false;
            }

            // Filter by brand name if provided
            if ($brand_name_filter) {
                $match = $match && strpos(strtolower(isset($item['nama_merek_produk']) ? $item['nama_merek_produk'] : ''), strtolower($brand_name_filter)) !== false;
            }

            return $match;
        }));

        // Pass the filtered data to the view
        $data['umkm'] = $umkm_data;

        // Load the view with the data
        $this->load->view('all', $data);
    }

    // Hasil pencarian UMKM (form di views/cari.php mengirim via GET:
    // nama_usaha, nama_merek_produk, kategori_produk)
    public function cari()
    {
        $nama_usaha = trim((string) $this->input->get('nama_usaha'));
        $nama_merek = trim((string) $this->input->get('nama_merek_produk'));
        $kategori   = trim((string) $this->input->get('kategori_produk'));

        $api_url = 'http://localhost:3000/api/umkm/status/disetujui';

        $response = $this->curl_request($api_url);
        if ($response === false) {
            log_message('error', 'Auth cari(): API request failed.');
            $this->session->set_flashdata('error', 'Gagal mengambil data UMKM dari server. Pastikan API berjalan.');
            $data['umkm'] = [];
            $data['approvedProducts'] = [];
            $data['filter'] = [
                'nama_usaha' => $nama_usaha,
                'nama_merek_produk' => $nama_merek,
                'kategori_produk' => $kategori,
            ];
            $this->load->view('cari', $data);
            return;
        }

        $umkm_data = json_decode($response, true);
        if (!is_array($umkm_data)) {
            log_message('error', 'Auth cari(): JSON decode error: ' . json_last_error_msg());
            $data['umkm'] = [];
            $data['approvedProducts'] = [];
            $data['filter'] = [
                'nama_usaha' => $nama_usaha,
                'nama_merek_produk' => $nama_merek,
                'kategori_produk' => $kategori,
            ];
            $this->load->view('cari', $data);
            return;
        }

        $filtered = array_values(array_filter($umkm_data, function ($item) use ($nama_usaha, $nama_merek, $kategori) {
            if (!is_array($item)) {
                return false;
            }
            $match = true;
            if ($kategori !== '') {
                $match = $match && strtolower(isset($item['kategori_produk']) ? $item['kategori_produk'] : '') === strtolower($kategori);
            }
            if ($nama_usaha !== '') {
                $match = $match && strpos(strtolower(isset($item['nama_usaha']) ? $item['nama_usaha'] : ''), strtolower($nama_usaha)) !== false;
            }
            if ($nama_merek !== '') {
                $match = $match && strpos(strtolower(isset($item['nama_merek_produk']) ? $item['nama_merek_produk'] : ''), strtolower($nama_merek)) !== false;
            }
            return $match;
        }));

        $data['umkm'] = $filtered;
        $data['approvedProducts'] = $filtered;
        $data['filter'] = [
            'nama_usaha' => $nama_usaha,
            'nama_merek_produk' => $nama_merek,
            'kategori_produk' => $kategori,
        ];

        $this->load->view('cari', $data);
    }

    public function peta() {
        // URL API
        $api_url = 'http://localhost:3000/api/umkm/status/disetujui/count';

        // Inisialisasi data default
        $data['kecamatan_data'] = [];
        $data['error'] = null;

        // Ambil data dari API
        $response = $this->curl_request($api_url);

        if ($response === false) {
            log_message('error', 'API request failed.');
            $data['error'] = 'Gagal mengambil data dari API.';
        } else {
            // Decode JSON
            $decoded_data = json_decode($response, true);

            if (json_last_error() === JSON_ERROR_NONE) {
                $data['kecamatan_data'] = $decoded_data;
            } else {
                log_message('error', 'JSON decode error: ' . json_last_error_msg());
                $data['error'] = 'Terjadi kesalahan saat memproses data.';
            }
        }

        // Kirim data ke view
        $this->load->view('peta', $data);
    }

    private function curl_request($url) {
        // Initialize cURL session
        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $url);              // URL to fetch
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    // Return the result as a string
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);    // Follow redirects (if any)
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);       // Timeout koneksi dalam detik
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);             // Timeout request dalam detik

        // Execute the request and fetch the response
        $response = curl_exec($ch);

        // Check for cURL errors
        if (curl_errno($ch) || $response === false) {
            log_message('error', 'cURL error: ' . curl_error($ch));
            $response = false;
        }

        // Close the cURL session
        curl_close($ch);

        return $response;
    }

    public function detail($id = null)
    {
        // Ambil ID dari parameter rute (detail/(:num)) atau fallback segment URL
        if ($id === null || $id === '') {
            $id = $this->uri->segment(2);
        }

        // Validasi ID: harus numerik -> tampilkan view error ramah
        if (empty($id) || !preg_match('/^\d+$/', (string) $id)) {
            $this->load->view('error_umkm', ['message' => 'ID UMKM tidak valid.']);
            return;
        }

        // API URLs
        $url_detail = 'http://localhost:3000/api/umkm/detail/' . $id;
        $url_status = 'http://localhost:3000/api/umkm/status/disetujui';

        $response1 = $this->curl_request($url_detail);
        $response2 = $this->curl_request($url_status);

        if ($response1 === false) {
            log_message('error', 'Auth detail(): gagal mengambil detail UMKM id ' . $id);
            $this->load->view('error_umkm', ['message' => 'Data UMKM tidak dapat diambil dari server. Pastikan API berjalan, lalu coba lagi.']);
            return;
        }

        // Decode JSON response
        $data_detail = json_decode($response1, true);
        $data_status = ($response2 === false) ? [] : json_decode($response2, true);

        // Periksa apakah ada error dalam decoding JSON
        if (json_last_error() !== JSON_ERROR_NONE || !is_array($data_detail)) {
            log_message('error', 'Auth detail(): JSON decode error: ' . json_last_error_msg());
            $this->load->view('error_umkm', ['message' => 'Terjadi kesalahan saat memproses data UMKM.']);
            return;
        }

        if (!is_array($data_status)) {
            $data_status = [];
        }

        // Cek apakah data detail UMKM ditemukan
        if (isset($data_detail['error'])) {
            $this->load->view('error_umkm', ['message' => $data_detail['error']]);
        } else {
            // Kirim data ke view
            $this->load->view('detail', [
                'umkm' => $data_detail,
                'umkm1' => $data_status
            ]);
        }
    }

    // Menampilkan Halaman Login
    public function index() {
        $this->load->view('auth/form_login');
    }

    public function register() {
        // Jika sudah login, redirect ke dashboard
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
            return;
        }

        // Aturan Validasi Formulir
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('confpassword', 'Confirm Password', 'required|matches[password]');
        $this->form_validation->set_rules('fullname', 'Full Name', 'required');
        $this->form_validation->set_rules('nomor_hp', 'Nomor HP', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

        // Cek jika form validasi gagal
        if ($this->form_validation->run() == FALSE) {
            // Cek apakah password dan confirm password tidak cocok
            if ($this->input->post('password') != $this->input->post('confpassword')) {
                $this->session->set_flashdata('error', 'Password dan Confirm Password tidak cocok.');
            }
            // Jika validasi gagal, kembali ke halaman register
            $this->load->view('auth/register');
        } else {
            // Ambil data dari form
            $data = json_encode([
                'username'     => $this->input->post('username'),
                'password'     => $this->input->post('password'),
                'confpassword' => $this->input->post('confpassword'),
                'fullname'     => $this->input->post('fullname'),
                'nomor_hp'     => $this->input->post('nomor_hp'),
                'email'        => $this->input->post('email'),
                'photo'        => 'default.png'  // Default photo untuk user baru
            ]);

            // Panggil API Node.js untuk Register
            $ch = curl_init($this->api_url . '/register');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($ch, CURLOPT_TIMEOUT, 15);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Accept: application/json'
            ]);

            $response = curl_exec($ch);

            if ($response === false || curl_errno($ch)) {
                log_message('error', 'Auth register cURL error: ' . curl_error($ch));
                curl_close($ch);
                $this->session->set_flashdata('error', 'Server registrasi tidak dapat dihubungi. Coba lagi nanti.');
                redirect('auth/register');
                return;
            }
            curl_close($ch);

            $result = json_decode($response, true);

            if (isset($result['success']) && $result['success'] == true) {
                // Jika berhasil, arahkan ke halaman login dengan pesan sukses
                $this->session->set_flashdata('success', 'Registrasi berhasil! Silakan login.');
                redirect('auth');
            } elseif (isset($result['error']) && $result['error'] == 'Username sudah digunakan') {
                // Jika username sudah digunakan, tampilkan pesan error
                $this->session->set_flashdata('error', 'Username sudah digunakan. Silakan pilih username lain.');
                redirect('auth/register');
            } else {
                // Jika gagal (error lainnya), tampilkan pesan error umum
                $this->session->set_flashdata('error', isset($result['error']) ? $result['error'] : 'Registrasi gagal. Silakan coba lagi.');
                redirect('auth/register');
            }
        }
    }

    // Proses Logout
    public function logout() {
        // Hapus semua session dan redirect ke login
        $this->session->sess_destroy();
        redirect('auth');
    }
}
