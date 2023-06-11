<?php
require_once(__DIR__ . '/app/config.php');

use MySite\Database;
use MySite\Blog;
use MySite\Page;
use MySite\Token;
use MySite\Utils;

Token::createToken();

$pdo = Database::getPDOInstance();
unset($_SESSION['blog']);

$logout_result = false;
if (filter_input(INPUT_GET, 'action') !== null) {
    switch (filter_input(INPUT_GET, 'action')) {
        case 'delete':
            Token::validateToken();
            // ブログ1件分の削除処理
            $id = filter_input(INPUT_POST, 'blogId');
            $userId = Blog::getBlogUserId($pdo, $id);
            $loginUserId = $_SESSION['loginUserId'];
            header('Content-Type: application/json');
            if ($userId === $loginUserId) {
                $del_result = Blog::deleteBlog($pdo, $id);
                if ($del_result) {
                    echo json_encode(['res' => 'OK']);
                } else {
                    echo json_encode(['res' => '※ブログの削除に失敗しました。']);
                }
            }
            exit;
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
$page_ins = new Page($pdo, 'blog', $items_per_page);
$data = $page_ins->itemsByPage();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyPortfolioSite -Blog-</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;1,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/destyle.min.css">
    <link rel="stylesheet" href="./css/my_modal.css">
    <link rel="stylesheet" href="./css/blog_page.css">
</head>

<body>
    <?php include_once './inc/header.php'; ?>

    <main data-token="<?= Utils::h($_SESSION['token']); ?>">
        <section class="section">
            <div class="blogs wrap">
                <h2 class="section_title">
                    <p>Blog</p>
                </h2>
                <div class="author">
                    <?php if ($logout_result) : ?>
                        <p>ログアウトしました。</p>
                    <?php elseif (isset($_SESSION['loginUserId'])) : ?>
                        <p><?= $_SESSION['loginUserName']; ?>さんログイン中</p><br class="sp_br">
                    <?php endif; ?>
                    <?php if (isset($_SESSION['loginUserId']) && $logout_result === false) : ?>
                        <a href="writing.php?base=blog">投稿</a>
                        <a href="?action=logout">ログアウト</a>
                    <?php else : ?>
                        <a href="./login.php?base=blog">管理者用</a>
                    <?php endif; ?>
                </div>

                <?php foreach ($data["items"] as $blog) : ?>
                    <div id="blog_<?= $blog["id"] ?>" class="blog">
                        <h3 class="blog_title"><?= $blog["title"]; ?></h3>
                        <div class="blog_wrap">
                            <?php if (!empty($blog["img"])) : ?>
                                <div class="blog_img modal">
                                    <img src="./upload/<?= $blog["img"]; ?>">
                                </div>
                            <?php endif; ?>
                            <div class="blog_content">
                                <?= $blog["text"]; ?>
                            </div>
                            <div class="blog_etc">
                                <p class="date"><?= $blog["create_time"]; ?></p>
                                <?php if (isset($_SESSION['loginUserId']) && $_SESSION['loginUserId'] === $blog['user_id']) : ?>
                                    <div class="auth_btns" data-blog="<?= $blog['id']; ?>" data-page="<?= $current_page; ?>">
                                        <span class=" err_del"></span>
                                        <span class="edit auth_btn">編集</span>
                                        <span class="delete auth_btn">削除</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <?php include './inc/page_nav.php'; ?>
            </div>
        </section>
    </main>




    <?php include './inc/footer.php'; ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="./js/my_modal.js"></script>
    <script src="./js/blog_page.js"></script>
</body>

</html>
