<?php
session_start();
$token = sha1(uniqid(mt_rand(), true));
$_SESSION['token'] = $token;

// ログインされていなければログイン画面へ
if (isset($_SESSION['login']) == false) {
    print 'ログインされていません';
    print '<a href="login.php">ログイン画面へ</a>';
    exit();
}
$name = $_SESSION['login_user'];


// 投稿がクリックされたら、データベースに保存
if (isset($_POST['submit'])) {
    if (!isset($_POST['token']) || $_POST['token'] != $token) {
        die('不正なアクセスが行われました');
    }

    $title = $_SESSION['title'];
    $text = $_SESSION['text'];
    $img = $_SESSION['img'];

    // データベースへの保存処理

    // blog.phpへ遷移
    header('Location: blog.php');
    exit();
}


?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyPortfolioSite -Blog Login-</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;1,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/destyle.min.css" </head>
    <link rel="stylesheet" href="./css/login_form.css">

<body>
    <div class="form_wrap">
        <h2 class="form_title">投稿内容確認</h2>
        <div>
            <p>ようこそ<?= $name; ?>さん</p>
            <a href="./blog.php">ブログ一覧へ</a>
        </div>
        <form class="form" action="writing.php" method="post">
            <div class="title">
                <p>タイトル</p>
            </div>
            <div class="preview">
                <img id="new_img">
            </div>
            <div class="text">
                <p name="text" maxlength="400" require>
                    投稿内容
                    投稿内容投稿内容
                    投稿内容投稿内容投稿内容
                    投稿内容投稿内容投稿内容投稿内容
                    投稿内容投稿内容投稿内容投稿内容投稿内容
                </p>
            </div>
            <input type="hidden" value="<?= $token; ?>">
            <div class="btns">
                <div class="btn btn1 h_btn btn_anime_inout">
                    <input type="submit" name="submit" value="投稿">
                </div>
                <a class="btn btn1 h_btn btn_anime_inout" href="history.back(-1)">戻る</a>
        </form>
    </div>
</body>

</html>
