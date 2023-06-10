<?php

class Token
{
    // トークンの作成
    public static function createToken()
    {
        if (!isset($_SESSION['token'])) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
    }

    // トークンのバリデート
    public static function validateToken()
    {
        if (!isset($_SESSION['token']) || filter_input(INPUT_POST, 'token') !== $_SESSION['token']) {
            print 'アクセスが不正です。<br>';
            print '<a href="login.php">ログイン画面へ</a>';
            exit();
        }
    }
}
