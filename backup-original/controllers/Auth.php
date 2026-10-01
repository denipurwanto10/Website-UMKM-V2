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

    // // Handle the login process
    public function login() {
        // Validasi form
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
    
        // Menambahkan pesan kesalahan kustom
        $this->form_validation->set_message('required', 'Harap isi %s.');
    
        if ($this->form_validation->run() === FALSE) {
            // Jika validasi form gagal, reload form login dengan error
            $this->load->view('auth/form_login');
        } else {
            // Mengambil input
            $username = $this->input->post('username');
            $password = $this->input->post('password');
    
            // Cek karakter mencurigakan dalam username atau password
            $pattern = "/(union|select|insert|update|delete|drop|--|#|'|\")/i";
            if (preg_match($pattern, $username) || preg_match($pattern, $password)) {
                // Jika ada input berbahaya, tampilkan pesan peringatan dan batalkan login
                $this->session->set_flashdata('error', 'Penggunaan input berbahaya terdeteksi! Akses ilegal tidak diperbolehkan.');
                redirect('auth/form_login');
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
    
            // Eksekusi request API
            $response = curl_exec($ch);
            curl_close($ch);
    
            // Decode response JSON dari Node.js
            $response_data = json_decode($response, true);
    
            // Menangani response dan memberikan pesan yang sesuai
            if (isset($response_data['success']) && $response_data['success'] == true) {
                // Login berhasil
                $this->session->set_userdata('user', $response_data['user']);
                $this->session->set_userdata('token', $response_data['token']);
    
                // Set success message
                $this->session->set_flashdata('success', 'Login berhasil!');
                redirect('auth/form_login');  // Redirect back to the login page
            } else {
                // Set error message
                $this->session->set_flashdata('error', $response_data['message'] ?? 'Login gagal. Silakan coba lagi.');
                redirect('auth/form_login');
            }
        }
    }
    

    //query tidak aman
    // public function login() {
    //     $this->form_validation->set_rules('username', 'Username', 'required');
    //     $this->form_validation->set_rules('password', 'Password', 'required');
        
    //     if ($this->form_validation->run() === FALSE) {
    //         $this->load->view('auth/form_login');
    //     } else {
    //         $username = $this->input->post('username');
    //         $password = $this->input->post('password');
            
    //         // QUERY RENTAN SQL INJECTION (Tanpa Parameterized Query)
    //         $post_data = json_encode([
    //             'username' => $username, // Input langsung dimasukkan ke dalam query
    //             'password' => $password
    //         ]);
            
    //         // Inisialisasi CURL
    //         $ch = curl_init();
    //         curl_setopt($ch, CURLOPT_URL, $this->api_url . '/login');
    //         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //         curl_setopt($ch, CURLOPT_POST, 1);
    //         curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    //         curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            
    //         // Eksekusi request API
    //         $response = curl_exec($ch);
    //         curl_close($ch);
            
    //         // Decode response JSON dari Node.js
    //         $response_data = json_decode($response, true);
            
    //         // Menangani response dan memberikan pesan yang sesuai
    //         if (isset($response_data['success']) && $response_data['success'] == true) {
    //             $this->session->set_userdata('user', $response_data['user']);
    //             $this->session->set_userdata('token', $response_data['token']);
    //             redirect('dashboard');
    //         } else {
    //             $error_message = $response_data['message'] ?? 'Login gagal. Silakan coba lagi.';
    //             $this->session->set_flashdata('error', $error_message);
    //             redirect('auth/form_login');
    //         }
    //     }
    // }
    
    
    public function all()
    {
        // Get the selected filters from the request (if any)
        $category_filter = $this->input->get('category'); // Get the category from query params
        $business_name_filter = $this->input->get('nama_usaha'); // Get the business name filter from query params
        $brand_name_filter = $this->input->get('nama_merek_produk'); // Get the brand name filter from query params
    
        // Define the API URL
        $api_url = 'http://localhost:3000/api/umkm/status/disetujui'; // Update with your actual API URL
    
        // Fetch the data from the API
        $response = file_get_contents($api_url);
        $umkm_data = json_decode($response, true);
    
        // Filter the UMKM data based on category, business name, and brand name if filters are applied
        $umkm_data = array_filter($umkm_data, function ($item) use ($category_filter, $business_name_filter, $brand_name_filter) {
            $match = true;
    
            // Filter by category if provided
            if ($category_filter) {
                $match = $match && strtolower($item['kategori_produk']) == strtolower($category_filter);
            }
    
            // Filter by business name if provided
            if ($business_name_filter) {
                $match = $match && strpos(strtolower($item['nama_usaha']), strtolower($business_name_filter)) !== false;
            }
    
            // Filter by brand name if provided
            if ($brand_name_filter) {
                $match = $match && strpos(strtolower($item['nama_merek_produk']), strtolower($brand_name_filter)) !== false;
            }
    
            return $match;
        });
    
        // Pass the filtered data to the view
        $data['umkm'] = $umkm_data;
    
        // Load the view with the data
        $this->load->view('all', $data);
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
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);             // Timeout for request in seconds
        
        // Execute the request and fetch the response
        $response = curl_exec($ch);
        
        // Check for cURL errors
        if(curl_errno($ch)) {
            log_message('error', 'cURL error: ' . curl_error($ch));
            $response = false;
        }
        
        // Close the cURL session
        curl_close($ch);
        
        return $response;
    }
    
    
     

    public function detail()
{
    // Ambil ID dari segment URL
    $id = $this->uri->segment(2);  

    // Validasi ID
    if (empty($id) || !is_numeric($id)) {
        show_error('Invalid UMKM ID.');
        return;
    }

    // API URLs
    $url_detail = "http://localhost:3000/api/umkm/detail/" . $id;
    $url_status = "http://localhost:3000/api/umkm/status/disetujui";

    // Initialize cURL multi handle
    $mh = curl_multi_init();
    
    // cURL handle untuk API detail UMKM
    $ch1 = curl_init();
    curl_setopt($ch1, CURLOPT_URL, $url_detail);
    curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
    
    // cURL handle untuk API UMKM dengan status disetujui
    $ch2 = curl_init();
    curl_setopt($ch2, CURLOPT_URL, $url_status);
    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);

    // Tambahkan kedua handle ke multi handle
    curl_multi_add_handle($mh, $ch1);
    curl_multi_add_handle($mh, $ch2);

    // Jalankan permintaan secara bersamaan
    do {
        $status = curl_multi_exec($mh, $active);
    } while ($status === CURLM_CALL_MULTI_PERFORM || $active);

    // Ambil response dari kedua request
    $response1 = curl_multi_getcontent($ch1);
    $response2 = curl_multi_getcontent($ch2);

    // Tutup cURL handles
    curl_multi_remove_handle($mh, $ch1);
    curl_multi_remove_handle($mh, $ch2);
    curl_multi_close($mh);

    // Decode JSON response
    $data_detail = json_decode($response1, true);
    $data_status = json_decode($response2, true);

    // Periksa apakah ada error dalam decoding JSON
    if (json_last_error() !== JSON_ERROR_NONE) {
        show_error('Error decoding JSON response.');
        return;
    }

    // Cek apakah data detail UMKM ditemukan
    if (isset($data_detail['error'])) {
        $this->load->view('error_view', ['message' => $data_detail['error']]);
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
            $usertype = $this->session->userdata('usertype');
            if ($usertype == 'Admin') {
                redirect('admin/dashboard');
            } elseif ($usertype == 'Owner') {
                redirect('umkm/dashboard');
            }
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
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Accept: application/json'
            ]);
    
            $response = curl_exec($ch);
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
