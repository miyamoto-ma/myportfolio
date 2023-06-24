<?php

session_start();

// 自分の情報(contactページ用)
define('NAME', '徳島 太郎');
define('KANA', 'とくしま たろう');
define('EMAIL1', 'tokushima@test.co.jp');   // 自動返信の送信元（From:）、自分への送信先
define('EMAIL2', 'tokushima10@test.com');    // 自分への送信元（From:）
define('SITENAME', 'MyPortfolioSite');          // サイト名
define('SITEURL', 'http://test/index.php');   // URL


// データベースの定数
// ローカル用
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
