<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
    {
        // Define the API URL
        $api_url = 'http://localhost:3000/api/umkm/status/disetujui'; // Update with your actual API URL

        // Fetch data from the API (guarded: API mati -> array kosong)
        $response = $this->fetch_api($api_url);
        $umkm_data = is_string($response) ? json_decode($response, true) : null;
        if (!is_array($umkm_data)) {
            $umkm_data = [];
        }

        $count = count($umkm_data);

        // Check if data is not empty
        if ($count > 0) {
            // Ambil maksimal 4 data acak; aman saat data < 4
            if ($count <= 4) {
                $random_umkm_data = array_values($umkm_data);
            } else {
                // Get 4 random UMKM data from the API response
                $random_keys = array_rand($umkm_data, 4); // Array of 4 random keys

                // If only 1 key is returned, array_rand() will return a single key instead of an array
                if (!is_array($random_keys)) {
                    $random_keys = [$random_keys];
                }

                // Use the random keys to select random UMKM data
                $random_umkm_data = [];
                foreach ($random_keys as $key) {
                    $random_umkm_data[] = $umkm_data[$key];
                }
            }

            // Pass the random data to the view
            $data['umkm'] = $random_umkm_data;
        } else {
            // Handle case where no data is returned from the API
            $data['umkm'] = [];
        }

        // Load the view with the data
        $this->load->view('index', $data);
    }

    /**
     * Ambil data API dengan cURL + timeout.
     * Mengembalikan string respons, atau FALSE bila API mati/timeout.
     */
    private function fetch_api($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);

        $response = curl_exec($ch);
        if (curl_errno($ch) || $response === false) {
            log_message('error', 'Welcome fetch_api cURL error: ' . curl_error($ch));
            $response = false;
        }
        curl_close($ch);

        return $response;
    }
}
