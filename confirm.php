<?php
require_once(__DIR__ . '/app/functions.php');
createToken();

// ログインされていなければログイン画面へ
if (!isset($_SESSION['loginUserId'])) {
    print 'ログインされていません';
    print '<a href="login.php">ログイン画面へ</a>';
    exit();
}
// ユーザー名を取得
$name = $_SESSION['loginUserName'];

// ユーザーIDを取得
$user_id = $_SESSION['loginUserId'];
// 現在時刻の取得
$create_time = date('Y-m-d H:i:s');
// PDOインスタンス取得
$pdo = getPDOInstance();

// 投稿タイトルを取得
$title = $_SESSION['title'];
// 投稿内容を取得
$text = $_SESSION['text'];
// 投稿画像を取得
$img = $_SESSION['img'];

if (filter_input(INPUT_GET, 'action') === 'add') {
    // ブログ投稿処理（失敗なら0）
    $blog_id = addBlog($pdo, $user_id, $title, $text, $img, $create_time);
    if ($blog_id == 0) {
        print 'ブログ投稿処理に失敗しました。<br>';
        print '<a href="writing.php">投稿画面へ</a>';
        exit();
    }

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
    <link rel="stylesheet" href="./css/confirm.css">

<body>
    <div class="form_wrap">
        <h2 class="form_title">投稿内容確認</h2>
        <div class="form_welcome">
            <p>ようこそ<?= $name; ?>さん</p>
            <a href="./blog.php">ブログ一覧へ</a>
        </div>
        <form class="form" action="?action=add" method="post">
            <div class="title">
                <p><?= $title; ?></p>
            </div>
            <div class="preview">
                <img id="new_img" src="./upload/<?= $img; ?>">
            </div>
            <div class="text">
                <p><?= $text; ?></p>
            </div>
            <div class="create_time">
                <p><?= $create_time; ?></p>
            </div>
            <input type="hidden" value="<?= h($_SESSION['token']); ?>">
            <div class="btns">
                <div class="btn btn1 h_btn btn_anime_inout">
                    <input type="submit" name="submit" value="投稿">
                </div>
                <a class="btn btn1 h_btn btn_anime_inout" href="writing.php">戻る</a>
        </form>
    </div>
</body>

</html>
