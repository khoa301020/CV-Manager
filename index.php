<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/helpers/set_layout.php';

// Looing for .env at the root directory
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

//--Switcher upper for detecting directory
$url_requested = $_SERVER['REQUEST_URI'];
$url_parsed = parse_url($url_requested);
$actual_path = $url_parsed['path'];
$query_string = $url_parsed['query'] ?? '';
if ($query_string) {
  parse_str($query_string, $output);
  $selector = $output['selector'];
  $validator = $output['validator'];
}

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
    set_layout('Forgot Password', 'common/forgot-password.php');
    break;
  case '/new-password':
    $_GET['selector'] = $selector;
    $_GET['validator'] = $validator;
    set_layout('Forgot Password', 'common/new-password.php');
    break;
  case '/apply':
    set_layout('Apply', 'candidates/apply.php');
    break;
  case '/admin':
    set_layout('Admin', 'admin/admin.php');
    break;
  case  '/success':
    include_once './resources/views/candidates/success.html';
    break;
  case  '/fail':
    include_once './resources/views/candidates/fail.html';
    break;
  default:
    echo '404';
    include_once('./resources/views/404.html');
}
