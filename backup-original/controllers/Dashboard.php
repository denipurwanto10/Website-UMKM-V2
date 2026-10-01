<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function index() {
      // Check if the user is logged in
      if (!$this->session->userdata('user')) {
        redirect('auth/form_login');
    }

    // Get user data from session
    $data['user'] = $this->session->userdata('user');
    $this->load->view('admin/dashboard', $data);
    }

}
