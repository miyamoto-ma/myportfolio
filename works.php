<?php
require_once(__DIR__ . '/app/config.php');

use MySite\Database;
use MySite\Works;
use MySite\Page;
use MySite\Token;
use MySite\Utils;

Token::createToken();
$pdo = Database::getPDOInstance();

$logout_result = false;
if (filter_input(INPUT_GET, 'action') !== null) {
    switch (filter_input(INPUT_GET, 'action')) {
        case 'delete':
            Token::validateToken();
            // ブログ1件分の削除処理
            $id = filter_input(INPUT_POST, 'itemId');
            $userId = Works::getWorkUserId($pdo, $id);
            $loginUserId = $_SESSION['loginUserId'];
            header('Content-Type: application/json');
            if ($userId === $loginUserId) {
                $del_result = Works::deleteWork($pdo, $id);
                if ($del_result) {
                    echo json_encode(['res' => 'OK']);
                } else {
                    echo json_encode(['res' => '※Workの削除に失敗しました。']);
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
$page_ins = new Page($pdo, 'works', $items_per_page);
$data = $page_ins->itemsByPage();
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

    <main class="main" data-token="<?= Utils::h($_SESSION['token']); ?>">
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
                        <a href="writing.php?base=works&d_flag=true">投稿</a>
                        <a href="?action=logout">ログアウト</a>
                    <?php else : ?>
                        <a href="./login.php?base=works">管理者用</a>
                    <?php endif; ?>
                </div>

                <div class="works">
                    <?php foreach ($data["items"] as $work) : ?>
                        <div id="item_<?= $work["id"] ?>" class="work">
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
                                <div class="blog_etc">
                                    <?php if (isset($_SESSION['loginUserId']) && $_SESSION['loginUserId'] === $work['user_id']) : ?>
                                        <div class="auth_btns" data-item_id="<?= $work['id']; ?>" data-page="<?= $data["current_page"]; ?>">
                                            <span class=" err_del"></span>
                                            <span class="edit auth_btn">編集</span>
                                            <span class="delete auth_btn">削除</span>
                                        </div>
                                    <?php endif; ?>
                                </div>
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
    <script src="./js/blog_page.js"></script>
</body>

</html>
