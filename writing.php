<?php
require_once(__DIR__ . '/app/config.php');

use MySite\blogClass;
use MySite\Token;
use MySite\Utils;
use MySite\Validate;

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
    print 'ログインされていません<br>';
    print '<a href="login.php?base=' . $base . '">ログイン画面へ</a>';
    exit();
}

// confirm.phpから戻るボタンで戻ってきた場合
if (isset($_SESSION['blog'])) {
    $blog = unserialize($_SESSION['blog']);
}

if (filter_input(INPUT_GET, 'action') === 'confirm') {
    Token::validateToken();
    // フォームデータを取得
    $title = Utils::h($_POST['title']);
    $text = Utils::h($_POST['text']);
    $img = '';
    if (mb_strlen($_FILES['img']['name']) > 0) {
        $filename = $_FILES['img']['name'];
        $upload_path = './upload/' . $filename;
        $upload_result = move_uploaded_file($_FILES['img']['tmp_name'], $upload_path);
        if ($upload_result) {
            $img = Utils::h($filename);
        } else {
            print '画像のアップロードに失敗しました。<br>';
            print '<a href="writing.php?base=' . $base . '">投稿画面へ</a>';
            exit();
        }
    }

    // バリデート
    $title_result = Validate::validate100($title, 'タイトル');
    $text_result = Validate::validate400($text, '本文');

    if ($title_result !== 'OK') {
        print $title_result . '<br>';
        print '<a href="writing.php?base=' . $base . '">投稿画面へ</a>';
        exit();
    }
    if ($text_result !== 'OK') {
        print $text_result . '<br>';
        print '<a href="writing.php?base=' . $base . '">投稿画面へ</a>';
        exit();
    }
    date_default_timezone_set('Asia/Tokyo');
    $create_time = date('Y-m-d H:i:s');
    $blog = new blogClass($title, $text, $img, $create_time);
    $_SESSION['blog'] = serialize($blog);
    header('Location: confirm.php?base=' . $base . '&from=writing');
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
    <link rel="stylesheet" href="./css/writing_form.css">

<body>
    <div class="form_wrap">
        <h2 class="form_title">投稿フォーム</h2>
        <div class="form_welcome">
            <p>ようこそ<?= $_SESSION['loginUserName']; ?>さん</p>
            <a href="./blog.php">ブログ一覧へ</a>
        </div>
        <form class="form" action="?base=<?= $base; ?>&action=confirm" method="post" enctype="multipart/form-data">
            <div class="input">
                <label for="title">
                    <p>タイトル(100文字以内)：</p>
                    <p><span id="char_title">0</span>/100</p>
                </label>
                <input id="title" type="text" name="title" maxlength="100" required value="<?= isset($_SESSION['blog']) ? $blog->title : ''; ?>">
            </div>
            <div class="input">
                <label for="text">
                    <p>内容(400文字以内)：</p>
                    <p><span id="char_text">0</span>/400</p>
                </label>
                <textarea id="text" name="text" maxlength="400" required><?= isset($_SESSION['blog']) ? $blog->text : ''; ?></textarea>
            </div>
            <div class="img">
                <span class="img_span">画像(任意)<br class="sp_br"><span class="img_ctn">(.jpg, .jpeg, .gif画像のみ(1MB以内))</span>：</span>
                <input id="file" type="file" name="img" accept=".jpg, .jpeg, .gif">
            </div>
            <div class="preview">
                <div class="new_preview">
                    プレビュー：
                    <img id="new_img">
                </div>
            </div>
            <input type="hidden" name="token" value="<?= Utils::h($_SESSION['token']); ?>">
            <div class="btns">
                <div class="btn btn1 h_btn btn_anime_inout">
                    <input type="submit" value="確認画面へ">
                </div>
                <div class="btn btn1 h_btn btn_anime_inout">
                    <input id="clear" type="reset" value="クリア">
                </div>
            </div>
        </form>
    </div>
    <script src="./js/writing.js"></script>
</body>

</html>
