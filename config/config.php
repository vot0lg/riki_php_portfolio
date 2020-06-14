<?php

define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/public_html');
define('MAX_FILE_SIZE', 1 * 1024 *1024);
define('THUMBNAIL_WIDTH', 300);

require_once(__DIR__ . '/autoload.php');
require_once(__DIR__ . '/functions.php');

session_start();

