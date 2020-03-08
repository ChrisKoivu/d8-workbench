<?php

// @codingStandardsIgnoreFile


$databases = [];


$settings['update_free_access'] = FALSE;

$settings['config_sync_directory'] =  $app_root . '/' . $site_path . '/files/csync';

if (file_exists($app_root . '/' . $site_path . '/settings.local.php')) {
  include $app_root . '/' . $site_path . '/settings.local.php';
} 

$settings['hash_salt'] = getenv('DRUPAL_HASH_SALT');
$databases['default']['default'] = [
  'database' => getenv('DRUPAL_DB_NAME'),
  'username' => getenv('DRUPAL_DB_USERNAME'),
  'password' => getenv('DRUPAL_DB_PASSWORD'),
  'host' => 'localhost',
  'port' => '3306',
  'driver' => 'mysql',
  'prefix' => '',
  'collation' => 'utf8mb4_general_ci',
];
