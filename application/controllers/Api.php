<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Api — endpoint JSON publik untuk kebutuhan frontend.
 *
 * Menyatukan hitungan statistik dari Node API (localhost:3000) di sisi
 * server, sehingga browser tidak perlu mengakses localhost:3000 langsung
 * (menghindari CORS / mixed-content / API mati di sisi klien).
 */
class Api extends CI_Controller {

    private $api_url = 'http://localhost:3000/api';

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
    }

    /**
     * GET api/stats
     * Mengembalikan: {"users":int,"owners":int,"umkm":int}
     * Setiap nilai default 0 bila Node API tidak dapat dihubungi.
     */
    public function stats() {
        $this->output->set_content_type('application/json');
        $this->output->set_output(json_encode([
            'users' => $this->fetch_count('/count-users'),
            'owners' => $this->fetch_count('/count-owners'),
            'umkm'  => $this->fetch_count('/count-umkm'),
        ]));
    }

    /**
     * Ambil satu angka count dari Node API. Selalu mengembalikan int.
     */
    private function fetch_count($path) {
        $ch = curl_init($this->api_url . $path);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        $response = curl_exec($ch);
        if (curl_errno($ch) || $response === false) {
            log_message('error', 'Api::stats cURL error (' . $path . '): ' . curl_error($ch));
            curl_close($ch);
            return 0;
        }
        curl_close($ch);
        $data = json_decode($response, true);
        if (is_array($data) && isset($data['count'])) {
            return (int) $data['count'];
        }
        if (is_array($data)) {
            return count($data);
        }
        return 0;
    }
}
