<?php

require __DIR__ . '/vendor/autoload.php';

// Looing for .env at the root directory
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

//--Switcher upper for detecting directory

$url_requested = $_SERVER['REQUEST_URI'];
$url_len = strlen($url_requested);

$actual_path = substr($url_requested, strpos($url_requested, '/'), $url_len);

switch ($actual_path) {
  case '/':
    include_once('./resources/views/common/default_index.php');
    break;
  case '/login':
    include_once('./resources/views/common/login.php');
    break;
  case '/register':
    include_once('./resources/views/common/register.php');
    break;
  case '/forgot-password':
    include_once('./resources/views/common/forgot-password.php');
    break;
  case '/apply':
    include_once('./resources/views/common/apply.php');
    break;
  case '/admin':
    include_once('./resources/views/admin/dashboard.php');
    break;
  default:
    include_once('./resources/views/404.html');
}
