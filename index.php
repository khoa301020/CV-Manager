<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/helpers/set_layout.php';

// Looing for .env at the root directory
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

//--Switcher upper for detecting directory
$url_requested = $_SERVER['REQUEST_URI'];
$url_len = strlen($url_requested);

$actual_path = substr($url_requested, strpos($url_requested, '/'), $url_len);

switch ($actual_path) {
  case '/':
    set_layout('MOR Software', 'common/default_index.php');
    break;
  case '/login':
    set_layout('Login', 'common/login.php');
    break;
  case '/register':
    set_layout('Register', 'common/register.php');
    break;
  case '/forgot-password':
    set_layout('Forgot Password', 'common/forgot_password.php');
    break;
  case '/apply':
    set_layout('Apply', 'candidates/apply.php');
    break;
  case '/admin':
    set_layout('Admin', 'admin/dashboard.php');
    break;
  default:
    include_once('./resources/views/404.html');
}
