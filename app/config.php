<?php

session_start();

// データベースの定数
// define('DSN', 'mysql:host=127.0.0.1;dbname=mysite;charset=utf8mb4');
define('DSN', 'mysql:host=' . $_SERVER['HTTP_HOST'] . ';dbname=mysite;charset=utf8mb4');
define('DB_USER', 'root');
define('DB_PASS', '');
define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST']);
