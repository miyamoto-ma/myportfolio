<?php
require_once(__DIR__ . '/app/config.php');

use MySite\Database;
use MySite\Works;
use MySite\Page;
use MySite\Token;
use MySite\Utils;

Token::createToken();

$pdo = Database::getPDOInstance();
// unset($_SESSION['works']);

$logout_result = false;
if (filter_input(INPUT_GET, 'action') !== null) {
    switch (filter_input(INPUT_GET, 'action')) {
            // case 'delete':
            //     Token::validateToken();
            //     // ブログ1件分の削除処理
            //     $id = filter_input(INPUT_POST, 'blogId');
            //     $userId = Blog::getBlogUserId($pdo, $id);
            //     $loginUserId = $_SESSION['loginUserId'];
            //     header('Content-Type: application/json');
            //     if ($userId === $loginUserId) {
            //         $del_result = Blog::deleteBlog($pdo, $id);
            //         if ($del_result) {
            //             echo json_encode(['res' => 'OK']);
            //         } else {
            //             echo json_encode(['res' => '※ブログの削除に失敗しました。']);
            //         }
            //     }
            //     exit;
        case 'logout':
            // ログアウト処理
            $logout_result = session_destroy();
            break;
        default:
            exit;
    }
}

// ページナビ用のデータ読み込み
$items_per_page = 3;    // 1ページに表示するアイテム数
$page_ins = new Page($pdo);
$data = $page_ins->itemsByPage('works', $items_per_page);

// $page = filter_input(INPUT_GET, 'page');
// $current_page = (int)(filter_input(INPUT_GET, 'page') ? filter_input(INPUT_GET, 'page') : 1);      // 現在のページ
// $items_per_page = 3;                                   // 1ページのアイテム数
// $blogs = Blog::getBlogsByPage($pdo, $current_page, $items_per_page);  // ブログデータ取得
// $total_items = Blog::getTotal($pdo);                          // 総アイテム数
// $total_pages = ceil($total_items / $items_per_page);    // 総ページ数
// // ページナビに表示する数値の配列を取得
// $around_pages = [];
// if ($current_page >= 1 && $current_page <= $total_pages) {
//     if ($current_page >= 3)  array_push($around_pages, $current_page - 2);
//     if ($current_page >= 2) array_push($around_pages, $current_page - 1);
//     array_push($around_pages, $current_page);
//     if ($current_page <= $total_pages - 1) array_push($around_pages, $current_page + 1);
//     if ($current_page <= $total_pages - 2) array_push($around_pages, $current_page + 2);
// } else {
//     header('Location: blog.php');
// }



?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyPortfolioSite -Works-</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;1,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/destyle.min.css">
    <link rel="stylesheet" href="./css/works_page.css">
</head>

<body>
    <?php include_once './inc/header.php'; ?>

    <main class="main">
        <section class="works_section section">
            <div class="works_wrap wrap">
                <h2 class="section_title">
                    <p>Works</p>
                </h2>

                <div class="author">
                    <?php if ($logout_result) : ?>
                        <p>ログアウトしました。</p>
                    <?php elseif (isset($_SESSION['loginUserId'])) : ?>
                        <p><?= $_SESSION['loginUserName']; ?>さんログイン中</p><br class="sp_br">
                    <?php endif; ?>
                    <?php if (isset($_SESSION['loginUserId']) && $logout_result === false) : ?>
                        <a href="writing.php">投稿</a>
                        <a href="?action=logout">ログアウト</a>
                    <?php else : ?>
                        <a href="./login.php">管理者用</a>
                    <?php endif; ?>
                </div>

                <div class="works">
                    <?php foreach ($data["items"] as $work) : ?>
                        <div class="work">
                            <p class="w_title"><?= $work["title"]; ?></p>
                            <div class="w_img_wrap">
                                <img src="./upload/<?= $work["img"]; ?>" alt="<?= $work["title"]; ?>の画像">
                            </div>
                            <div class="contents">
                                <p class="skill">
                                    使用したスキル：
                                    <span><?= $work["skill"]; ?></span>
                                </p>
                                <p class="description">
                                    <?= $work["text"]; ?>
                                </p>
                                <?php if ($work["link1"] !== '') : ?>
                                    <a href="<?= $work["link1"]; ?>" target="_blank"><?= $work["link_text1"]; ?></a>
                                <?php endif; ?>
                                <?php if ($work["link2"] !== '') : ?>
                                    <a href="<?= $work["link2"]; ?>" target="_blank"><?= $work["link_text2"]; ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
                <?php include './inc/page_nav.php'; ?>
            </div>
        </section>
    </main>

    <?php include './inc/footer.php'; ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="./js/works_page.js"></script>
</body>

</html>
