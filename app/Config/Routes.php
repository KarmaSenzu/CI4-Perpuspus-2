<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Routes Home 
$routes->get('/', 'Home::home');
$routes->get('/home', 'Home::home');
$routes->get('/daftar-buku', 'Home::daftar_buku');
$routes->get('/contact', 'Home::contact');
$routes->get('/faq', 'Home::faq');

// Routes untuk Admin
$routes->get('admin/login-admin', 'Admin::login');
$routes->post('admin/autentikasi-login', 'Admin::autentikasi');
$routes->get('admin/dashboard', 'Admin::dashboard');
$routes->get('admin/profile', 'Admin::profile');
$routes->post('admin/update-profile', 'Admin::updateProfile');
$routes->post('admin/update-password', 'Admin::updatePassword');
$routes->get('admin/logout', 'Admin::logout');

// Routes untuk Master Data Admin
$routes->get('admin/master-data-admin', 'Admin::master_data_admin');
$routes->get('admin/input-data-admin', 'Admin::input_data_admin');
$routes->post('admin/simpan-data-admin', 'Admin::simpan_data_admin');
$routes->get('admin/edit-data-admin/(:alphanum)', 'Admin::edit_data_admin/$1');
$routes->post('admin/update-data-admin/(:segment)', 'Admin::update_data_admin/$1');
$routes->get('admin/hapus-data-admin/(:alphanum)', 'Admin::hapus_data_admin/$1');
$routes->get('admin/restore-data-admin', 'Admin::restore_data_admin');

// Routes untuk Master Data Anggota
$routes->get('admin/master-data-anggota', 'Anggota::master_data_anggota');
$routes->get('admin/input-data-anggota', 'Anggota::input_data_anggota');
$routes->post('admin/simpan-data-anggota', 'Anggota::simpan_data_anggota');
$routes->get('admin/edit-data-anggota/(:segment)', 'Anggota::edit_data_anggota/$1');
$routes->post('admin/update-data-anggota', 'Anggota::update_data_anggota');
$routes->get('admin/hapus-anggota/(:segment)', 'Anggota::hapus_data_Anggota/$1');
$routes->get('admin/restore-data-anggota', 'Anggota::restore_data_anggota');

// Routes untuk Master Data Buku
$routes->get('admin/master-data-buku', 'Buku::master_data_buku');
$routes->get('admin/input-data-buku', 'Buku::input_data_buku');
$routes->post('admin/simpan-data-buku', 'Buku::simpan_data_buku');
$routes->get('admin/edit-data-buku/(:any)', 'Buku::edit_data_buku/$1');
$routes->post('admin/update-data-buku/(:any)', 'Buku::update_data_buku');
$routes->get('admin/hapus-data-buku/(:any)', 'Buku::hapus_data_buku/$1');
$routes->get('admin/restore-data-buku', 'Buku::restore_data_buku');

// Routes untuk Master Data Kategori
$routes->get('admin/master-data-kategori', 'Kategori::master_data_kategori');
$routes->get('admin/input-data-kategori', 'Kategori::input_data_kategori');
$routes->post('admin/simpan-data-kategori', 'Kategori::simpan_data_kategori');
$routes->get('admin/edit-data-kategori/(:segment)', 'Kategori::edit_data_kategori/$1');
$routes->post('admin/update-data-kategori', 'Kategori::update_data_kategori');
$routes->get('admin/hapus-data-kategori/(:segment)', 'Kategori::hapus_data_kategori/$1');
$routes->get('admin/restore-data-kategori', 'Kategori::restore_data_kategori');

// Routes untuk Master Data Rak
$routes->get('admin/master-data-rak', 'Rak::master_data_rak');
$routes->get('admin/input-data-rak', 'Rak::input_data_rak');
$routes->post('admin/simpan-data-rak', 'Rak::simpan_data_rak');
$routes->get('admin/edit-data-rak/(:any)', 'Rak::edit_data_rak/$1');
$routes->post('admin/update-data-rak', 'Rak::update_data_rak');
$routes->get('admin/hapus-data-rak/(:any)', 'Rak::hapus_data_rak/$1');
$routes->get('admin/restore-data-rak', 'Rak::restore_data_rak');

// Routes untuk Peminjaman
$routes->get('admin/transaksi-data-peminjaman', 'Peminjaman::transaksi_data_peminjaman');
$routes->get('admin/simpan-transaksi-peminjaman', 'Peminjaman::simpan_transaksi_peminjaman');
$routes->post('admin/simpan-transaksi-peminjaman', 'Peminjaman::simpan_transaksi_peminjaman');
$routes->get('admin/detail-peminjaman/(:segment)', 'Peminjaman::detail_peminjaman/$1');  
$routes->get('admin/peminjaman-step1', 'Peminjaman::peminjaman_step1');
$routes->get('admin/peminjaman-step2', 'Peminjaman::peminjaman_step2');
$routes->post('admin/peminjaman-step2', 'Peminjaman::peminjaman_step2');
$routes->get('admin/peminjaman-step3', 'Peminjaman::peminjaman_step3');
$routes->get('admin/simpan-temp-pinjam/(:any)', 'Peminjaman::simpan_temp_pinjam/$1');
$routes->get('admin/hapus-temp-pinjam/(:any)', 'Peminjaman::hapus_temp_pinjam/$1');

// Routes untuk Pengembalian
$routes->get('admin/transaksi-data-pengembalian', 'Pengembalian::transaksi_data_pengembalian');
$routes->get('admin/proses-pengembalian/(:any)', 'Pengembalian::proses_pengembalian/$1');
$routes->post('admin/proses-pengembalian', 'Pengembalian::proses_pengembalian');
$routes->get('admin/detail-pengembalian/(:segment)', 'Pengembalian::detail_pengembalian/$1');

// Routes untuk Denda
$routes->get('admin/denda', 'Denda::denda');
$routes->get('admin/detail-denda/(:any)', 'Denda::detail_denda/$1');
$routes->get('admin/bayar-denda/(:num)', 'Denda::bayarDenda/$1');
$routes->post('admin/bayar-denda', 'Denda::bayarDenda');
$routes->post('admin/bayar-denda/(:any)', 'Denda::bayarDenda/$1');

// Routes untuk Profile User
$routes->get('user/login-user', 'User::login');
$routes->post('user/autentikasi-login', 'User::autentikasi');
$routes->get('user/registrasi', 'User::registrasi');
$routes->post('user/proses-registrasi', 'User::prosesRegistrasi');
$routes->get('user/verify-email', 'User::verifyEmail');
$routes->post('user/verify-code', 'User::verifyCode');
$routes->get('user/profile', 'User::profile');
$routes->get('user/edit-profile', 'User::editProfile');
$routes->post('user/update-profile', 'User::updateProfile');
$routes->post('user/change-password', 'User::changePassword');
$routes->post('user/update-password', 'User::updatePassword');
$routes->get('user/logout', 'User::logout');

// Routes untuk User
$routes->get('user/dashboard', 'User::dashboard');
$routes->get('user/buku', 'User::buku');
$routes->get('user/detail-buku/(:segment)', 'User::detail_buku/$1');
$routes->get('user/kategori', 'User::kategori');
$routes->get('user/rak', 'User::rak');
$routes->get('user/downloadPdf', 'User::downloadPdf');

// Routes untuk Transaksi User
$routes->get('user/peminjaman', 'User::peminjaman');
$routes->get('user/simpan-transaksi-peminjaman', 'User::simpan_transaksi_peminjaman');
$routes->post('user/simpan-transaksi-peminjaman', 'User::simpan_transaksi_peminjaman');
$routes->get('user/detail-peminjaman/(:segment)', 'User::detail_peminjaman/$1');  
$routes->get('user/peminjaman-step1', 'User::peminjaman_step1');
$routes->post('user/peminjaman-step1', 'User::peminjaman_step1');
$routes->get('user/peminjaman-step2', 'User::peminjaman_step2');
$routes->get('user/peminjaman-step2/(:any)', 'User::peminjaman_step2/$1');
$routes->get('user/simpan-temp-pinjam/(:any)', 'User::simpan_temp_pinjam/$1');
$routes->get('user/hapus-temp-pinjam/(:any)', 'User::hapus_temp_pinjam/$1');
$routes->get('user/pengembalian', 'User::pengembalian');
$routes->get('user/detail-pengembalian/(:segment)', 'User::detail_pengembalian/$1');
$routes->get('user/proses-pengembalian/(:any)', 'User::proses_pengembalian/$1');
$routes->post('user/proses-pengembalian', 'User::proses_pengembalian');

// Routes untuk Denda
$routes->get('user/denda-user', 'User::denda');
$routes->get('user/detail-denda/(:any)', 'User::detail_denda/$1');
$routes->get('user/bayar-denda/(:num)', 'User::bayarDenda/$1');
$routes->post('user/bayar-denda/(:segment)', 'User::bayarDenda/$1');
$routes->post('user/bayar-denda', 'User::bayarDenda');



