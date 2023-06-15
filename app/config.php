<?php

session_start();

// 自分の情報(contactページ用)
define('NAME', '宮本 学');
define('KANA', 'みやもと まなぶ');
define('EMAIL1', 'miyamotoma@hotmail.co.jp');   // 自動返信の送信元（From:）、自分への送信先
define('EMAIL2', 'miyamotoma678@gmail.com');    // 自分への送信元（From:）


// データベースの定数
// ローカル用
// define('DSN', 'mysql:host=127.0.0.1;dbname=mysite;charset=utf8mb4');
define('DSN', 'mysql:host=' . $_SERVER['HTTP_HOST'] . ';dbname=mysite;charset=utf8mb4');
define('DB_USER', 'root');
define('DB_PASS', '');
define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST']);
// サーバー用
// define('DSN', 'mysql:host=mysql1.php.starfree.ne.jp;dbname=freemm_mysite;charset=utf8mb4');
// define('DB_USER', 'freemm_manabu');
// define('DB_PASS', 'PortMmEmarl0615');
// define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST']);

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
