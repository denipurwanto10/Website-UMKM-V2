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

        // Use file_get_contents() to fetch data from the API
        $response = file_get_contents($api_url);

        // Decode the JSON response from the API
        $umkm_data = json_decode($response, true);

        // Check if data is not empty
        if (isset($umkm_data) && !empty($umkm_data)) {
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

            // Pass the random data to the view
            $data['umkm'] = $random_umkm_data;
        } else {
            // Handle case where no data is returned from the API
            $data['umkm'] = [];
        }

        // Load the view with the data
        $this->load->view('index', $data);
    }
}
