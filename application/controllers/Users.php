<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
    private $api_url = 'http://localhost:3000/api/users'; // URL Web Service Node.js

    public function __construct() {
        parent::__construct();
        $this->load->library(['form_validation', 'upload', 'session']);
        $this->load->helper('url');
    }

    // Menampilkan semua user
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
            $data['users'] = [];
            $this->session->set_flashdata('error', 'Gagal mengambil data dari API.');
        } else {
            $users = json_decode($json_data, true);
            $data['users'] = $users;
        }
    
        // Load the view and pass the data
        $this->load->view('admin/users', $data);
    }
    public function index1() {
        // Check if the user is logged in
        if (!$this->session->userdata('user')) {
            redirect('auth/form_login'); // Redirect to login if not logged in
        }
    
        // Get user data from session
        $data['user'] = $this->session->userdata('user');
    
        // Get users data from API
        $json_data = @file_get_contents($this->api_url);
    
        if ($json_data === FALSE) {
            $data['users'] = [];
            $this->session->set_flashdata('error', 'Gagal mengambil data dari API.');
        } else {
            $users = json_decode($json_data, true);
            $data['users'] = $users;
        }
    
        // Load the view and pass the data
        $this->load->view('admin/users1', $data);
    }

    public function profil() {
        // Check if the user is logged in
        if (!$this->session->userdata('user')) {
            redirect('auth/form_login'); // Redirect to login if not logged in
        }
    
        // Get user data from session
        $data['user'] = $this->session->userdata('user');
    
        // Get users data from API
        $json_data = @file_get_contents($this->api_url);
    
        if ($json_data === FALSE) {
            $data['users'] = [];
            $this->session->set_flashdata('error', 'Gagal mengambil data dari API.');
        } else {
            $users = json_decode($json_data, true);
            $data['users'] = $users;
        }
    
        // Load the view and pass the data
        $this->load->view('admin/profil', $data);
    }
    

    public function create() {
        // Check if the user is logged in
        if (!$this->session->userdata('user')) {
            redirect('auth/form_login'); // Redirect to login if not logged in
        }

        // Get user data from session
        $data['user'] = $this->session->userdata('user');

        // Load the view and pass the user data
        $this->load->view('admin/create_user', $data);
    }

    // Menyimpan user baru
   public function store() {
        // Membuat folder upload jika belum ada
        $upload_path = './uploads/users/';
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, true);
        }

        // Konfigurasi upload file
        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = 2048;  // Maksimal 2MB
        $config['file_ext_tolower'] = TRUE;
        $config['encrypt_name'] = TRUE;
        $this->upload->initialize($config);

        // Upload Photo (jika ada)
        $photo = 'default.png';
        if (!empty($_FILES['photo']['name'])) {
            if (!$this->upload->do_upload('photo')) {
                $error = $this->upload->display_errors();
                $this->session->set_flashdata('error', 'Gagal mengunggah foto: ' . $error);
                redirect('users/create');
                return;
            } else {
                $upload_data = $this->upload->data();
                $photo = $upload_data['file_name'];
            }
        }

        // Form validation rules
        $this->form_validation->set_rules('username', 'Username', 'required|alpha_numeric');
        $this->form_validation->set_rules('fullname', 'Nama Lengkap', 'required');
        $this->form_validation->set_rules('usertype', 'Jenis Pengguna', 'required');
        $this->form_validation->set_rules('nomor_hp', 'Nomor HP', 'required|numeric');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
        $this->form_validation->set_rules('confpassword', 'Konfirmasi Password', 'required|matches[password]');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('users/create');
            return;
        }

        // Data untuk dikirim ke API
        $post_data = [
            'username' => $this->input->post('username'),
            'fullname' => $this->input->post('fullname'),
            'usertype' => $this->input->post('usertype'),
            'nomor_hp' => $this->input->post('nomor_hp'),
            'email' => $this->input->post('email'),
            'password' => $this->input->post('password'),
            'confpassword' => $this->input->post('confpassword'),
            'photo' => $photo
        ];

        // Kirim data ke API
        try {
        $response = $this->curl_post($this->api_url, $post_data);

        if (isset($response['success']) && $response['success']) {
            $this->session->set_flashdata('success', 'User berhasil ditambahkan!');
            // Mengembalikan response JSON untuk AJAX
            if ($this->input->is_ajax_request()) {
                echo json_encode(['status' => 'success', 'message' => 'User berhasil ditambahkan!']);
                return;
            }
            redirect('users');
        } else {
            $error_message = isset($response['error']) ? $response['error'] : 'Terjadi kesalahan tidak diketahui';
            throw new Exception($error_message);
        }
    } catch (Exception $e) {
        if ($this->input->is_ajax_request()) {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menambahkan user: ' . $e->getMessage()]);
            return;
        }
        $this->session->set_flashdata('error', 'Gagal menambahkan user: ' . $e->getMessage());
        redirect('users/create');
    }
    }

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
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            curl_close($ch);
            throw new Exception('CURL Error: ' . $error_msg);
        }
        
        curl_close($ch);
        
        $decoded_response = json_decode($response, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Invalid JSON response: ' . $response);
        }
        
        return $decoded_response;
    }
    

// Edit User (for user type 1)
public function edit($username) {
    $this->edit_user($username, 'users', 'admin/edit_user');
}

// Edit User (for user type 2)
public function edit1($username) {
    $this->edit_user($username, 'users1', 'admin/edit_user1');
}

// General function to handle edit (for both user types)
private function edit_user($username, $redirect_url, $view_file) {
    // Fetch user data from API
    $json_data = @file_get_contents($this->api_url . '/' . $username);

    if ($json_data === FALSE) {
        $this->session->set_flashdata('error', 'Failed to fetch user data from API.');
        redirect($redirect_url);
    } else {
        $user = json_decode($json_data, true);
        $data['user'] = $user;
    }

    $this->load->view($view_file, $data);
}

// Update User (for user type 1)
public function update($username) {
    $this->update_user($username, 'users', 'users/edit/' . $username);
}

// Update User (for user type 2)
public function update1($username) {
    $this->update_user($username, 'users1', 'users/edit1/' . $username);
}

// General function to handle update (for both user types)
private function update_user($username, $redirect_url, $redirect_path) {
    // Handle file upload (photo)
    $photo = $this->handle_file_upload('photo', 'old_photo');
    if ($photo === false) {
        redirect($redirect_path);
        return;
    }

    // Form validation rules
    $this->set_form_validation_rules();

    if ($this->form_validation->run() === FALSE) {
        $this->session->set_flashdata('error', validation_errors());
        redirect($redirect_path);
        return;
    }

    // Password validation: Check if password and confirm password match
    if ($this->input->post('password') !== $this->input->post('confpassword')) {
        $this->session->set_flashdata('error', 'Password dan Konfirmasi Password tidak cocok.');
        redirect($redirect_path);
        return;
    }

    // Collect data for API request
    $data = $this->collect_data($photo);

    // Send data to API using CURL
    $url = $this->api_url . '/' . $username;
    try {
        $response = $this->curl_put($url, $data);
        if (isset($response['success']) && $response['success']) {
            $this->session->set_flashdata('message', 'Pengguna berhasil diperbarui.');
            redirect($redirect_url);
        } else {
            $error_message = isset($response['error']) ? $response['error'] : json_encode($response);
            $this->session->set_flashdata('error', 'Pengguna gagal diperbarui: ' . $error_message);
            redirect($redirect_path);
        }
    } catch (Exception $e) {
        $this->session->set_flashdata('error', 'Gagal menghubungi server, coba lagi nanti.');
        redirect($redirect_path);
    }
}

// Handle file upload
private function handle_file_upload($file_input_name, $old_photo_input_name) {
    $upload_path = './uploads/users/';
    if (!is_dir($upload_path)) {
        mkdir($upload_path, 0777, true);
    }

    // Configure upload
    $config['upload_path'] = $upload_path;
    $config['allowed_types'] = 'jpg|jpeg|png|gif';
    $config['max_size'] = 2048;  // Max size 2MB
    $config['file_ext_tolower'] = TRUE;
    $config['encrypt_name'] = TRUE;
    $this->upload->initialize($config);

    // Use old photo by default if no new file is uploaded
    $photo = $this->input->post($old_photo_input_name);
    if (!empty($_FILES[$file_input_name]['name'])) {
        if (!$this->upload->do_upload($file_input_name)) {
            $error = $this->upload->display_errors();
            $this->session->set_flashdata('error', 'Gagal mengunggah foto: ' . $error);
            return false;
        } else {
            $upload_data = $this->upload->data();
            $photo = $upload_data['file_name'];  // Store only the filename
        }
    }
    return $photo;
}

// Form validation rules
private function set_form_validation_rules() {
    $this->form_validation->set_rules('fullname', 'Nama Lengkap', 'required');
    $this->form_validation->set_rules('usertype', 'Jenis Pengguna', 'required');
    $this->form_validation->set_rules('nomor_hp', 'Nomor HP', 'required|numeric');
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

    // Password validation is optional, if it's filled
    if ($this->input->post('password') || $this->input->post('confpassword')) {
        $this->form_validation->set_rules('password', 'Password', 'min_length[8]');
        $this->form_validation->set_rules('confpassword', 'Konfirmasi Password', 'matches[password]');
    }
}

// Collect user data for API update
private function collect_data($photo) {
    $data = [
        'fullname' => $this->input->post('fullname'),
        'usertype' => $this->input->post('usertype'),
        'nomor_hp' => $this->input->post('nomor_hp'),
        'email' => $this->input->post('email'),
        'photo' => $photo
    ];

    // Include password if provided
    if ($this->input->post('password')) {
        $data['password'] = $this->input->post('password');
        $data['confpassword'] = $this->input->post('confpassword');
    }

    return $data;
}

// CURL PUT function to update user data on the API
private function curl_put($url, $data) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
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




    // Menghapus user berdasarkan username
public function delete($username) {
    // URL untuk DELETE request
    $url = $this->api_url . '/' . $username;

    // Mengirim DELETE request ke Web Service
    try {
        $response = $this->curl_delete($url);

        if (isset($response['success']) && $response['success']) {
            $this->session->set_flashdata('message', 'Pengguna berhasil dihapus.');
        } else {
            $error_message = isset($response['error']) ? $response['error'] : json_encode($response);
            $this->session->set_flashdata('error', $error_message);
        }
    } catch (Exception $e) {
        $this->session->set_flashdata('error', 'Pengguna gagal dihapus, silahkan coba lagi.');
    }

    // Redirect kembali ke halaman users
    redirect('users');
}
// Fungsi CURL DELETE
private function curl_delete($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
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

}
