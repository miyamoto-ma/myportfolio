<?php

session_start();

// データベースの定数
// define('DSN', 'mysql:host=127.0.0.1;dbname=mysite;charset=utf8mb4');
define('DSN', 'mysql:host=' . $_SERVER['HTTP_HOST'] . ';dbname=mysite;charset=utf8mb4');
define('DB_USER', 'root');
define('DB_PASS', '');
define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST']);

spl_autoload_register(function ($class) {
    $prefix = 'MySite\\';

    if (strpos($class, $prefix) === 0) {
        $filename = sprintf(__DIR__ . '/%s.php', substr($class, strlen($prefix)));
        if (file_exists($filename)) {
            require($filename);
        } else {
            print 'File not found: ' . $filename;
            exit;
        }
    }
});
