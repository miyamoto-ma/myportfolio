<?php

// 埋め込む文字をエスケープする関数
function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}


// トークンの作成
function createToken()
{
    // セッションスタート
    session_start();
    if (!isset($_SESSION['token'])) {
        $_SESSION['token'] = bin2hex(random_bytes(32));
    }
}

// トークンのバリデート
function validateToken()
{
    if (!isset($_SESSION['token']) || $_POST['token'] !== $_SESSION['token']) {
        print 'アクセスが不正です。<br>';
        print '<a href="login.php">ログイン画面へ</a>';
        exit();
    }
}

// ブログ投稿のバリデート
// title 100文字以内 空はだめ
function validateTitle($title)
{
    if (empty($title)) {
        return 'タイトルを入力してください。';
    } elseif (mb_strlen($title) > 100) {
        return 'タイトルは100文字以内で入力してください。';
    } else {
        return 'OK';
    }
}

// text 400文字以内 空はだめ
function validateText($text)
{
    if (empty($text)) {
        return '本文を入力してください。';
    } elseif (mb_strlen($text) > 100) {
        return '本文は400文字以内で入力してください。';
    } else {
        return 'OK';
    }
}





// データベースの定数
// define('DSN', 'mysql:host=127.0.0.1;dbname=myblog;charset=utf8mb4');
define('DSN', 'mysql:host=' . $_SERVER['HTTP_HOST'] . ';dbname=myblog;charset=utf8mb4');
define('DB_USER', 'root');
define('DB_PASS', '');
define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST']);

// データベースに接続する準備
function getPDOInstance()
{
    try {
        $pdo = new PDO(
            DSN,
            DB_USER,
            DB_PASS,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]
        );
        return $pdo;
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit();
    }
}

// アカウントIDの取得
function getAccount($pdo, $name, $pass)
{
    $sql = "SELECT id FROM accounts WHERE name = :name AND pass = :pass";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue('name', $name, PDO::PARAM_STR);
    $stmt->bindValue('pass', $pass, PDO::PARAM_STR);
    $stmt->execute();
    $id_array = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!empty($id_array)) {
        return $id_array['id'];
    }
}

// ブログのすべて取得する
function getBlogsAll($pdo)
{
    $sql = "SELECT id, user_id, title, text, img, create_time FROM BLOGS ORDER BY id DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $blogs;
}

// ブログの1件分のユーザーIDを取得
function getBlogUserId($pdo, $id)
{
    $sql = "SELECT user_id FROM BLOGS WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue('id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $userId_arr = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!empty($userId_arr)) {
        return $userId_arr['user_id'];
    }
}

// ブログの投稿
function addBlog($pdo, $user_id, $title, $text, $img, $create_time)
{
    $sql = "INSERT INTO BLOGS (user_id, title, text, img, create_time) VALUES (:user_id, :title, :text, :img, :create_time)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue('user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindValue('title', $title, PDO::PARAM_STR);
    $stmt->bindValue('text', $text, PDO::PARAM_STR);
    $stmt->bindValue('img', $img, PDO::PARAM_STR);
    $stmt->bindValue('create_time', $create_time, PDO::PARAM_STR);
    $stmt->execute();
    return (int)$pdo->lastInsertId();
}

// ブログの編集
function editBlog($pdo, $id, $title, $text, $img)
{
    $sql = "UPDATE BLOGS SET title = :title, text = :text, img = :img WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue('title', $title, PDO::PARAM_STR);
    $stmt->bindValue('text', $text, PDO::PARAM_STR);
    $stmt->bindValue('img', $img, PDO::PARAM_STR);
    $stmt->bindValue('id', $id, PDO::PARAM_INT);
    $result = $stmt->execute();
    return $result;
}

// ブログの削除
function deleteBlog($pdo, $id)
{
    $sql = "DELETE FROM BLOGS WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue('id', $id, PDO::PARAM_INT);
    $result = $stmt->execute();
    return $result;
}
