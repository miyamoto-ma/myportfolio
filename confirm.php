<?php
require_once(__DIR__ . '/app/config.php');
// require_once(__DIR__ . '/app/Database.php');
// require_once(__DIR__ . '/app/Blog.php');
// require_once(__DIR__ . '/app/blogClass.php');
// require_once(__DIR__ . '/app/Token.php');
// require_once(__DIR__ . '/app/Utils.php');

use MySite\Database;
use MySite\Blog;
// use MySite\blogClass;
use MySite\Token;
use MySite\Utils;

Token::createToken();

if (filter_input(INPUT_GET, 'base') !== null) {
    $base = filter_input(INPUT_GET, 'base');
    if ($base !== 'blog' && $base !== 'works') {
        print 'blogページもしくはworksページより投稿してください。<br>';
        print '<a href="works.php">worksページへ</a><br>';
        print '<a href="blog.php">blogページへ</a>';
        exit;
    }
} else {
    print 'blogページもしくはworksページより投稿してください。<br>';
    print '<a href="works.php">worksページへ</a><br>';
    print '<a href="blog.php">blogページへ</a>';
    exit;
}

// ログインされていなければログイン画面へ
if (!isset($_SESSION['loginUserId'])) {
    print 'ログインされていません。<br>';
    print '<a href="login.php?base=' . $base . '">ログイン画面へ</a>';
    exit();
}
// ページ番号の取得
$current_page = 1;
if (filter_input(INPUT_GET, 'page') !== null) {
    $current_page = filter_input(INPUT_GET, 'page');
}

$blog = unserialize($_SESSION['blog']);
// url
$back_url = '';     // 戻るボタンのhref
$action = '';       // フォームのaction
if (filter_input(INPUT_GET, 'from') === 'writing') {
    $back_url = 'writing.php?base=' . $base;
    $action = 'add';
} elseif (filter_input(INPUT_GET, 'from') === 'edit') {
    $back_url = 'edit.php?base=' . $base . '&action=edit&blogId=' . $blog->id . '&page=' . $current_page;
    $action = 'update';
}

// セッションにblogがセットされていない場合
if (!isset($_SESSION['blog'])) {
    print 'ブログ情報が取得できませんでした。<br>';
    print '<a href="' . $back_url . '">戻る</a>';
}



// ユーザー名を取得
$name = $_SESSION['loginUserName'];

// ユーザーIDを取得
$user_id = $_SESSION['loginUserId'];
// PDOインスタンス取得
$pdo = Database::getPDOInstance();
// ブログIDを取得
if (filter_input(INPUT_GET, 'from') === 'edit' || filter_input(INPUT_GET, 'action') === 'update') {
    $id = $blog->id;
}
// 投稿タイトルを取得
$title = $blog->title;
// 投稿内容を取得
$text = $blog->text;
// 投稿画像を取得
$img = '';
if (filter_input(INPUT_GET, 'from') === 'writing' || filter_input(INPUT_GET, 'action') === 'add') {
    $img = $blog->img;
} elseif (filter_input(INPUT_GET, 'from') === 'edit' || filter_input(INPUT_GET, 'action') === 'update') {
    if ($_SESSION['check']) {
        $img = $blog->new_img;
    } elseif (mb_strlen($blog->img) > 0) {
        $img = $blog->img;
    }
}
// 投稿日時を取得
$create_time = $blog->create_time;


if (filter_input(INPUT_GET, 'action') !== null) {
    Token::validateToken();
    switch (filter_input(INPUT_GET, 'action')) {
        case 'add':
            // ブログ投稿処理（失敗なら0）
            $act_result = Blog::addBlog($pdo, $user_id, $title, $text, $img, $create_time);
            break;
        case 'update':
            // ブログ更新処理（失敗ならfalse)
            $act_result = Blog::editBlog($pdo, $id, $title, $text, $img);
            unset($_SESSION['check']);
            break;
        default:
            exit;
    }
    if (!$act_result) {
        print 'ブログ投稿/更新処理に失敗しました。<br>';
        print '<a href="' . $back_url . '">戻る</a>';
        exit();
    }
    unset($_SESSION['blog']);
    header('Location: blog.php?page=' . $current_page);
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
        <form class="form" action="?base=<?= $base; ?>&action=<?= $action; ?>&page=<?= $current_page; ?>" method="post">
            <div class="title">
                <p><?= $title; ?></p>
            </div>
            <?php if (!empty($img)) : ?>
                <div class="preview">
                    <img id="new_img" src="./upload/<?= $img; ?>">
                </div>
            <?php endif; ?>
            <div class="text">
                <p><?= $text; ?></p>
            </div>
            <div class="create_time">
                <p><?= $create_time; ?></p>
            </div>
            <input type="hidden" name="token" value="<?= Utils::h($_SESSION['token']); ?>">
            <div class="btns">
                <div class="btn btn1 h_btn btn_anime_inout">
                    <input type="submit" name="submit" value="投稿">
                </div>
                <a class="btn btn1 h_btn btn_anime_inout" href="<?= $back_url; ?>">戻る</a>
        </form>
    </div>
</body>

</html>
