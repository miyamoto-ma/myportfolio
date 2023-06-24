<?php
require_once(__DIR__ . '/app/config.php');

use MySite\Database;
use MySite\Blog;

$pdo = Database::getPDOInstance();

// ブログIDの取得
$id = filter_input(INPUT_GET, 'blogId');

// 該当ブログデータの読み込み
$blog = Blog::getBlog($pdo, $id);
if (!$blog) {
    print 'ブログデータが取得できませんでした。<br>';
    print '<a href="./index.php">戻る</a>';
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyPortfolioSite -Blog One-</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;1,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/destyle.min.css">
    <link rel="stylesheet" href="./css/my_modal.css">
    <link rel="stylesheet" href="./css/blog_one.css">
</head>

<body>
    <?php include_once './inc/header.php'; ?>

    <div class="blogs wrap">
        <h2 class="section_title">
            <p>Blog -No.<?= $blog->id; ?>-</p>
        </h2>
        <div id="item_<?= $blog->id; ?>" class="blog">
            <h3 class="blog_title"><?= $blog->title; ?></h3>
            <div class="blog_wrap">
                <?php if (!empty($blog->img)) : ?>
                    <div class="blog_img modal">
                        <img src="./upload/<?= $blog->img; ?>">
                    </div>
                <?php endif; ?>
                <div class="blog_content">
                    <?= nl2br($blog->text); ?>
                </div>
                <div class="blog_etc">
                    <p class="date"><?= $blog->create_time; ?></p>
                    <span>
                        <a href="./index.php#blog">Homeページヘ</a>
                        <a href="./blog.php">Blog一覧へ</a>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="./js/my_modal.js"></script>
</body>

</html>
