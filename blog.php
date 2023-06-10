<?php
require_once(__DIR__ . '/app/functions.php');
createToken();
$pdo = getPDOInstance();
unset($_SESSION['blog']);

$logout_result = false;
if (filter_input(INPUT_GET, 'action') !== null) {
    switch (filter_input(INPUT_GET, 'action')) {
        case 'delete':
            validateToken();
            // ブログ1件分の削除処理
            $id = filter_input(INPUT_POST, 'blogId');
            $userId = getBlogUserId($pdo, $id);
            $loginUserId = $_SESSION['loginUserId'];
            header('Content-Type: application/json');
            if ($userId === $loginUserId) {
                $del_result = deleteBlog($pdo, $id);
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

// 投稿内容をデータベースから取得
// $blogs = getBlogsAll($pdo);      // 全てのブログを取得する用
$page = filter_input(INPUT_GET, 'page');
$current_page = (int)(filter_input(INPUT_GET, 'page') ? filter_input(INPUT_GET, 'page') : 1);      // 現在のページ
$items_per_page = 3;                                   // 1ページのアイテム数
$blogs = getBlogsByPage($pdo, $current_page, $items_per_page);  // ブログデータ取得
$total_items = getTotal($pdo);                          // 総アイテム数
$total_pages = ceil($total_items / $items_per_page);    // 総ページ数
// ページナビに表示する数値の配列を取得
$around_pages = [];
if ($current_page >= 1 && $current_page <= $total_pages) {
    if ($current_page >= 3)  array_push($around_pages, $current_page - 2);
    if ($current_page >= 2) array_push($around_pages, $current_page - 1);
    array_push($around_pages, $current_page);
    if ($current_page <= $total_pages - 1) array_push($around_pages, $current_page + 1);
    if ($current_page <= $total_pages - 2) array_push($around_pages, $current_page + 2);
} else {
    header('Location: blog.php');
}
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

    <main data-token="<?= h($_SESSION['token']); ?>">
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
                        <a href="writing.php">投稿</a>
                        <a href="?action=logout">ログアウト</a>
                    <?php else : ?>
                        <a href="./login.php">管理者用</a>
                    <?php endif; ?>
                </div>

                <?php foreach ($blogs as $blog) : ?>
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

                <div class="pagenate">
                    <?php if ($current_page >= 3) : ?>
                        <a href="?page=1" class="page_arrow">≪</a>
                    <?php endif; ?>
                    <?php if ($current_page >= 2) : ?>
                        <a href="?page=<?= $current_page - 1; ?>" class="page_arrow">&lt;</a>
                    <?php endif; ?>
                    <?php if ($current_page >= 4) : ?>
                        <span class="page_dots">...</span>
                    <?php endif; ?>

                    <?php foreach ($around_pages as $num) : ?>
                        <?php if ($num !== $current_page) : ?>
                            <a href="?page=<?= $num; ?>" class="page_btn"><?= $num; ?></a>
                        <?php else : ?>
                            <p class="page_btn current_btn"><?= $num; ?></p>
                        <?php endif; ?>
                    <?php endforeach; ?>

                    <?php if ($current_page <= ($total_pages - 3)) : ?>
                        <span class="page_dots">...</span>
                    <?php endif; ?>
                    <a href=""></a>
                    <?php if ($current_page <= $total_pages - 1) : ?>
                        <a href="?page=<?= $current_page + 1; ?>" class="page_arrow">&gt;</a>
                    <?php endif; ?>
                    <?php if ($current_page <= ($total_pages - 2)) : ?>
                        <a href="?page=<?= $total_pages; ?>" class="page_arrow">≫</a>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </main>




    <?php include './inc/footer.php'; ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="./js/my_modal.js"></script>
    <script src="./js/blog_page.js"></script>
</body>

</html>
