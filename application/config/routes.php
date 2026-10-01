<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| Setiap rute di bawah ini dipetakan ke controller/method yang ADA.
| Matriks verifikasi (rute -> controller::method -> status):
|   default_controller -> Welcome::index              ADA
|   all                -> Auth::all                   ADA
|   cari               -> Auth::cari                  ADA
|   peta               -> Auth::peta                  ADA
|   detail/(:num)      -> Auth::detail                ADA
|   dashboard          -> Dashboard::index            ADA
|   umkm/*             -> Umkm::*                     ADA (termasuk delete1)
|   users/*            -> Users::*                    ADA (termasuk create1/store1/edit/delete1)
|   promosi*           -> Promosi::*                  ADA
|   auth/*, login, register, logout -> Auth::*        ADA
| Rute mati yang DIHAPUS: platform (controller Platform tidak ada),
| duplikat menunggu/disetujui/ditolak/promosi/umkm-create_umkm.
*/
$route['default_controller'] = 'welcome';

// Halaman publik
$route['all']          = 'auth/all';
$route['cari']         = 'auth/cari';
$route['peta']         = 'auth/peta';
$route['detail/(:num)'] = 'auth/detail/$1';

// Auth
$route['auth/form_login'] = 'auth/form_login';
$route['login']           = 'auth/form_login';
$route['login/submit']    = 'auth/login';
$route['register']        = 'auth/register';
$route['logout']          = 'auth/logout';

// Dashboard (satu-satunya pintu dashboard)
$route['dashboard'] = 'dashboard/index';

// Users (Admin)
$route['users']                = 'users/index';
$route['users/index']          = 'users/index';
$route['users/create']         = 'users/create';
$route['users/store']          = 'users/store';
$route['users/edit/(:any)']    = 'users/edit/$1';
$route['users/update/(:any)']  = 'users/update/$1';
$route['users/delete/(:any)']  = 'users/delete/$1';

// Users (Owner)
$route['users1']               = 'users/index1';
$route['users/create1']        = 'users/create1';
$route['users/store1']         = 'users/store1';
$route['users/edit1/(:any)']    = 'users/edit1/$1';
$route['users/update1/(:any)']  = 'users/update1/$1';
$route['users/delete1/(:any)']  = 'users/delete1/$1';

// Profil
$route['profil'] = 'users/profil';

// UMKM (Admin)
$route['umkm/menunggu']              = 'umkm/menunggu';
$route['umkm/disetujui']             = 'umkm/disetujui';
$route['umkm/ditolak']               = 'umkm/ditolak';
$route['umkm/create']                = 'umkm/create';
$route['umkm/create_umkm']           = 'umkm/create_umkm';
$route['umkm/store']                 = 'umkm/store';
$route['umkm/edit/(:num)']           = 'umkm/edit/$1';
$route['umkm/update/(:num)']         = 'umkm/update/$1';
$route['umkm/delete/(:num)']         = 'umkm/delete/$1';
$route['umkm/disetujui/delete/(:num)'] = 'umkm/deleteDisetujui/$1';
$route['umkm/ditolak/delete/(:num)']   = 'umkm/deleteDitolak/$1';

// UMKM (Owner)
$route['data_umkm']              = 'umkm/data_umkm';
$route['umkm/create1']           = 'umkm/create1';
$route['umkm/store1']            = 'umkm/store1';
$route['umkm/edit1/(:num)']      = 'umkm/edit1/$1';
$route['umkm/update1/(:num)']    = 'umkm/update1/$1';
$route['umkm/delete1/(:num)']    = 'umkm/delete1/$1';

// Promosi (Admin)
$route['promosi']                 = 'promosi/index';
$route['promosi/create']          = 'promosi/create';
$route['promosi/store']           = 'promosi/store';
$route['promosi/edit/(:num)']     = 'promosi/edit/$1';
$route['promosi/update/(:num)']   = 'promosi/update/$1';
$route['promosi/delete/(:num)']   = 'promosi/delete/$1';

// Promosi (Owner)
$route['promosi1']                = 'promosi/index1';
$route['promosi/create1']         = 'promosi/create1';
$route['promosi/store1']          = 'promosi/store1';
$route['promosi/edit1/(:num)']    = 'promosi/edit1/$1';
$route['promosi/update1/(:num)']  = 'promosi/update1/$1';
$route['promosi/delete1/(:num)']  = 'promosi/delete1/$1';

// Error and special route handling
$route['api/stats'] = 'api/stats';  // Proxy statistik beranda (bypass CORS/API langsung dari browser)
$route['404_override'] = '';  // Dibiarkan kosong: controller Errors tidak ada
$route['translate_uri_dashes'] = FALSE;
