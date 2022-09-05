<?php

namespace Config;

use App\Controllers\KelolaLaporan;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('login');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->match(['get', 'post'], 'login', 'Login::index', ["filter" => "noauth"]);
$routes->group("admin", ["filter" => "auth"], function ($routes) {
    $routes->get("/", "DashboardAdmin::index");
    $routes->get("/kelolauser", "KelolaUser::index");
    $routes->get("/kelolapeserta", "KelolaPeserta::index");
    $routes->get("/kelolalemdik", "KelolaLemdik::index");
    $routes->get("/keloladiklat", "KelolaDiklat::index");
    $routes->get("/kelolaperencanaan", "KelolaPerencanaan::index");
    $routes->get("/transaksimasuk", "TransaksiMasuk::index");
    $routes->get("/datauser", "KelolaUser::getDataUser");
    $routes->get("/transaksimasuk/detail/(:num)/(:num)", "TransaksiMasuk::detailtransaksi");
    $routes->get("/transaksimasuk/tambah/(:num)/(:num)", "TransaksiMasuk::tambahtransaksi");
    $routes->get("/403", "Login::blokir");
});
$routes->group("bendahara", ["filter" => "auth"], function ($routes) {
    $routes->get("/", "DashboardBendahara::index");
    $routes->get("/transaksimasuk", "TransaksiMasuk::index");
    $routes->get("/gajipengajar", "KelolaGajiPengajar::index");
    $routes->get("/gajipengajar/cetakbuktigaji/(:num)", "KelolaGajiPengajar::cetak_bukti_gaji");
    $routes->get("/datauser", "KelolaUser::getDataUser");
    // Routes Transaksi Masuk
    $routes->get("/transaksimasuk/detail/(:num)/(:num)", "TransaksiMasuk::detailtransaksi");
    $routes->get("/transaksimasuk/tambah/(:num)/(:num)", "TransaksiMasuk::tambahtransaksi");
    $routes->get("/transaksimasuk/verifikasi/(:num)", "TransaksiMasuk::verifikasi");
    $routes->get("/transaksikeluar", "TransaksiKeluar::index");
    // Routes Kelola Laporan Pembayaran Diklat
    $routes->get('/kelolalaporan', [KelolaLaporan::class, 'index']);
    $routes->get("/kelolalaporan/cetak_transaksimasuk", "KelolaLaporan::cetak_lap_transaksimasuk");
    $routes->get('/kelolalaporan/gajipengajar', [KelolaLaporan::class, 'gajipengajar']);
    $routes->get("/403", "Login::blokir");
});
$routes->group("kepalaprogram", ["filter" => "auth"], function ($routes) {
    $routes->get("/", "DashboardKaprog::index");
    $routes->get("/kelolaperencanaan", "KelolaPerencanaan::index");
});
$routes->group("pesertadidik", ["filter" => "auth"], function ($routes) {
    $routes->get("/", "DashboardPeserta::index");
    $routes->get("/transaksimasuk", "TransaksiMasuk::index");
    $routes->get("/pembayaranpeserta", "PembayaranPeserta::index");
    $routes->get("/pembayaranpeserta/history", "PembayaranPeserta::history");
});


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
