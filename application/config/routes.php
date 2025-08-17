<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome'; // Default controller (set this to your actual controller)


$route['menunggu'] = 'Umkm/menunggu';  // Route for UMKM waiting
$route['disetujui'] = 'Umkm/disetujui';  // Route for UMKM approved
$route['ditolak'] = 'Umkm/ditolak';  // Route for UMKM rejected
$route['platform'] = 'Platform/index';  // Route for platform page
$route['promosi'] = 'Promosi/index';  // Route for promotional data
$route['umkm/create_umkm'] = 'Umkm/create_umkm'; // Mengarah ke fungsi create_umkm di controller Umkm


// User Routes
$route['users'] = 'users/index';
$route['users/index'] = 'users/index';
$route['users1'] = 'users/index1';  // This should map the URL to the index1 method in the Users controller
$route['profil'] = 'users/profil';  // This should map the URL to the index1 method in the Users controller

$route['users/create'] = 'users/create';  // Show create user form
$route['users/store'] = 'users/store';  // Store new user data
$route['users/create1'] = 'users/create1';  // Show create user form
$route['users/store1'] = 'users/store1';  // Store new user data
$route['users/edit/(:any)'] = 'users/edit/$1';  // Edit user form
$route['users/edit1/(:any)'] = 'users/edit1/$1';  // Edit user form

$route['users/update/(:any)'] = 'users/update/$1';  // Update user data
$route['users/update1/(:any)'] = 'users/update1/$1';  // Update user data
$route['users/delete/(:any)'] = 'users/delete/$1';  // Delete user data
$route['register'] = 'auth/register';


// UMKM Routes

$route['umkm/menunggu'] = 'Umkm/menunggu';  // Route for UMKM waiting
$route['data_umkm'] = 'Umkm/data_umkm'; 
$route['umkm/disetujui'] = 'Umkm/disetujui';  // Route for UMKM approved
$route['umkm/ditolak'] = 'Umkm/ditolak';  // Route for UMKM rejected
$route['umkm/create_umkm'] = 'Umkm/create_umkm'; // Route to create UMKM
$route['umkm/edit/(:num)'] = 'Umkm/edit/$1';  // Route untuk edit UMKM // Edit UMKM dengan ID tertentu
$route['umkm/update/(:num)'] = 'umkm/update/$1';
$route['umkm/delete/(:num)'] = 'Umkm/delete/$1';  // Delete UMKM by ID
$route['umkm/update1/(:num)'] = 'umkm/update1/$1';
$route['umkm/delete1/(:num)'] = 'Umkm/delete1/$1';  // Delete UMKM by ID
$route['umkm/disetujui/delete/(:num)'] = 'Umkm/deleteDisetujui/$1';  // Delete UMKM by ID from approved list
$route['umkm/ditolak/delete/(:num)'] = 'Umkm/deleteDitolak/$1';  // Delete UMKM by ID from approved list

$route['auth/form_login'] = 'auth/form_login';
$route['login'] = 'auth/form_login';   // Route to show the login form
$route['login/submit'] = 'auth/login'; // Route to handle the login action

$route['all'] = 'auth/all';
$route['cari'] = 'auth/cari';
$route['peta'] = 'auth/peta';

$route['promosi'] = 'promosi/index'; // Display all promosi
$route['promosi/edit/(:num)'] = 'Promosi/edit/$1';  // Route untuk edit UMKM // Edit UMKM dengan ID tertentu
$route['promosi/update/(:num)'] = 'Promosi/update/$1';  // Route untuk edit UMKM // Edit UMKM dengan ID tertentu
$route['promosi/edit1/(:num)'] = 'Promosi/edit1/$1';  // Route untuk edit UMKM // Edit UMKM dengan ID tertentu
$route['promosi/update1/(:num)'] = 'Promosi/update1/$1';  // Route untuk edit UMKM // Edit UMKM dengan ID tertentu
$route['promosi/delete1/(:num)'] = 'promosi/delete1/$1';
$route['promosi/delete/(:num)'] = 'promosi/delete/$1';
$route['promosi1'] = 'promosi/index1';




$route['detail/(:num)'] = 'auth/detail/$1';





// Add your additional routes here as needed
$route['logout'] = 'auth/logout';


// Error and special route handling
$route['404_override'] = '';  // Controller/method to call for missing pages (usually 'errors/page_missing')
$route['translate_uri_dashes'] = FALSE;  // Convert dashes in URL to underscores for controllers and methods (set to TRUE if you use dashes in controller/method names)
