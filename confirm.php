<?php
require_once(__DIR__ . '/app/functions.php');
require_once(__DIR__ . '/app/blogClass.php');
createToken();

// ログインされていなければログイン画面へ
if (!isset($_SESSION['loginUserId'])) {
    print 'ログインされていません。<br>';
    print '<a href="login.php">ログイン画面へ</a>';
    exit();
}

// 戻るボタンのhref
$back_url = '';
$action = '';
if (filter_input(INPUT_GET, 'from') === 'writing') {
    $back_url = 'writing.php';
    $action = 'add';
} elseif (filter_input(INPUT_GET, 'from') === 'edit') {
    $back_url = 'edit.php?action=edit&blogId=' . $_SESSION['blog']->id;
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
$pdo = getPDOInstance();
// ブログIDを取得
if (filter_input(INPUT_GET, 'from') === 'edit' || filter_input(INPUT_GET, 'action') === 'update') {
    $id = $_SESSION['blog']->id;
}
// 投稿タイトルを取得
$title = $_SESSION['blog']->title;
// 投稿内容を取得
$text = $_SESSION['blog']->text;
// 投稿画像を取得
$img = '';
if (filter_input(INPUT_GET, 'from') === 'writing' || filter_input(INPUT_GET, 'action') === 'add') {
    $img = $_SESSION['blog']->img;
} elseif (filter_input(INPUT_GET, 'from') === 'edit' || filter_input(INPUT_GET, 'action') === 'update') {
    if ($_SESSION['check']) {
        $img = $_SESSION['blog']->new_img;
    } elseif (mb_strlen($_SESSION['blog']->img) > 0) {
        $img = $_SESSION['blog']->img;
    }
}
// 投稿日時を取得
$create_time = $_SESSION['blog']->create_time;


if (filter_input(INPUT_GET, 'action') !== null) {
    validateToken();
    switch (filter_input(INPUT_GET, 'action')) {
        case 'add':
            // ブログ投稿処理（失敗なら0）
            $act_result = addBlog($pdo, $user_id, $title, $text, $img, $create_time);
            break;
        case 'update':
            // ブログ更新処理（失敗ならfalse)
            $act_result = editBlog($pdo, $id, $title, $text, $img);
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
        <form class="form" action="?action=<?= $action; ?>" method="post">
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
            <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
            <div class="btns">
                <div class="btn btn1 h_btn btn_anime_inout">
                    <input type="submit" name="submit" value="投稿">
                </div>
                <a class="btn btn1 h_btn btn_anime_inout" href="<?= $back_url; ?>">戻る</a>
        </form>
    </div>
</body>

</html>
