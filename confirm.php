<?php
require_once(__DIR__ . '/app/config.php');

use MySite\Database;
use MySite\Blog;
use MySite\Works;
use MySite\Token;
use MySite\Utils;

Token::createToken();

if (filter_input(INPUT_GET, 'base') !== null && filter_input(INPUT_GET, 'from') !== null) {
    $base = filter_input(INPUT_GET, 'base');
    $from = filter_input(INPUT_GET, 'from');
    if (($base !== 'blog' && $base !== 'works') || ($from !== 'writing' && $from !== 'edit')) {
        print 'blogページもしくはworksページより投稿/編集してください。<br>';
        print '<a href="works.php">worksページへ</a><br>';
        print '<a href="blog.php">blogページへ</a>';
        exit;
    }
} else {
    print 'blogページもしくはworksページより投稿/編集してください。<br>';
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

if ($base === 'blog') {
    $item = unserialize($_SESSION['blog']);
} elseif ($base === 'works') {
    $item = unserialize($_SESSION['work']);
}
// url
$back_url = '';     // 戻るボタンのhref
$action = '';       // フォームのaction
if ($from === 'writing') {
    $back_url = 'writing.php?base=' . $base;
    $action = 'add';
} elseif ($from === 'edit') {
    $back_url = 'edit.php?base=' . $base . '&action=edit&blogId=' . $item->id . '&page=' . $current_page;
    $action = 'update';
}

// セッションにblogもしくはworkがセットされていない場合
if (($base === 'blog' && !isset($_SESSION['blog'])) || ($base === 'works' && !isset($_SESSION['work']))) {
    print 'データが取得できませんでした。<br>';
    print '<a href="' . $back_url . '">戻る</a>';
}

// Postで戻ってきたaction
$r_action = filter_input(INPUT_GET, 'action');

// ユーザー名を取得
$name = $_SESSION['loginUserName'];

// ユーザーIDを取得
$user_id = $_SESSION['loginUserId'];
// PDOインスタンス取得
$pdo = Database::getPDOInstance();
// アイテムのIDを取得
if ($from === 'edit' || $r_action === 'update') {
    $id = $item->id;
}
// 投稿タイトルを取得
$title = $item->title;
// 投稿内容を取得
$text = $item->text;
// 投稿画像を取得
$img = '';
if ($from === 'writing' || $r_action === 'add') {
    $img = $item->img;
} elseif ($from === 'edit' || $r_action === 'update') {
    if (filter_input(INPUT_GET, 'check') === 'on') {
        $img = $item->new_img;
    } elseif (mb_strlen($item->img) > 0) {
        $img = $item->img;
    }
}

if ($base === 'works') {
    $skill = $item->skill;
    $link1 = $item->link1;
    $link_text1 = $item->link_text1;
    $link2 = $item->link2;
    $link_text2 = $item->link_text2;
} elseif ($base === 'blog') {
    // 投稿日時を取得
    $create_time = $item->create_time;
}


if ($r_action !== null) {
    Token::validateToken();
    switch ($r_action) {
        case 'add':
            if ($base === 'blog') {
                // ブログ投稿処理（失敗なら0）
                $act_result = Blog::addBlog($pdo, $user_id, $title, $text, $img, $create_time);
            } elseif ($base === 'works') {
                // work投稿処理（失敗なら0）
                $act_result = Works::addWork($pdo, $user_id, $title, $skill, $text, $img, $link1, $link2, $link_text1, $link_text2);
            }
            break;
        case 'update':
            if ($base === 'blog') {
                // ブログ更新処理（失敗ならfalse)
                $act_result = Blog::editBlog($pdo, $id, $title, $text, $img);
            } elseif ($base === 'works') {
                // work更新処理（失敗ならfalse)
                $act_result = Works::editWork($pdo, $id, $title, $skill, $text, $img, $link1, $link2, $link_text1, $link_text2);
            }
            break;
        default:
            exit;
    }

    if (!$act_result) {
        print 'ブログ投稿/更新処理に失敗しました。<br>';
        print '<a href="' . $back_url . '">戻る</a>';
        exit();
    }
    if ($base === 'blog') {
        unset($_SESSION['blog']);
    } elseif ($base === 'works') {
        unset($_SESSION['work']);
    }
    header('Location: ' . $base . '.php?page=' . $current_page);
    exit();
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyPortfolioSite -Confirm-</title>
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
            <a href="./<?= $base; ?>.php"><?= $base; ?>一覧へ</a>
        </div>
        <form class="form" action="?base=<?= $base; ?>&from=<?= $from; ?>&action=<?= $action; ?>&page=<?= $current_page; ?>" method="post">
            <div class="title">
                <p><?= $title; ?></p>
            </div>
            <?php if (!empty($img)) : ?>
                <div class="preview">
                    <img id="new_img" src="./upload/<?= $img; ?>">
                </div>
            <?php endif; ?>
            <?php if ($base === 'works') : ?>
                <div class="works_contents">
                    使用したスキル：
                    <p><?= $skill; ?></p>
                </div>
            <?php endif; ?>
            <div class="text">
                <p><?= nl2br($text); ?></p>
            </div>
            <?php if ($base === 'works') : ?>
                <?php if ($link1 !== '') : ?>
                    <div class="works_contents">
                        link1：
                        <p><?= $link_text1; ?></p>
                        <p>[url: <?= $link1; ?>]</p>
                    </div>
                <?php endif; ?>
                <?php if ($link2 !== '') : ?>
                    <div class="works_contents">
                        link2：
                        <p><?= $link_text2; ?></p>
                        <p>[url: <?= $link2; ?>]</p>
                    </div>
                <?php endif; ?>
            <?php elseif ($base === 'blog') : ?>
                <div class="create_time">
                    <p><?= $create_time; ?></p>
                </div>
            <?php endif; ?>
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
