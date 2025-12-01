<?php
// session_start();
// Biến môi trường, dùng chung toàn hệ thống
// Khai báo dưới dạng HẰNG SỐ để không phải dùng $GLOBALS
$_SESSION['BASE_URL'] = 'http://localhost/Quan_ly_tour_du_lich-Travel_Siuu/';
define('BASE_URL', 'http://localhost/Quan_ly_tour_du_lich-Travel_Siuu/');
define('Views_Admin', './views/Admin/');
define('Views_Client', './views/Client/');
define('Views_Router', './router/');

// database
define('DB_HOST', 'localhost');
define('DB_PORT', 3306);
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'travel_siuu');  // Tên database

define('PATH_ROOT', __DIR__ . '/../');
