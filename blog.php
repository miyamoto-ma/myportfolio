<?php
require_once(__DIR__ . '/app/functions.php');
session_start();

// 投稿内容をデータベースから取得
$pdo = getPDOInstance();
$blogs = getBlogsAll($pdo);

// ログアウト処理
$logout_result = false;
if (filter_input(INPUT_GET, 'action') === 'logout') {
    $logout_result = session_destroy();
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
    <link rel="stylesheet" href="./css/blog_page.css">
</head>

<body>
    <header class="header">
        <div class="header_wrap">
            <div class="h_title">
                <a href="./index.html">
                    <img class="icon" src="./img/icon.png" alt="">
                    <h1>MyPortfolioSite</h1>
                </a>
            </div>
            <nav class="h_nav">
                <ul>
                    <li><a href="./index.html">Home</a></li>
                    <li><a href="./about.html">About</a></li>
                    <li><a href="./works.html">Works</a></li>
                    <li><a class="active" href="./blog.php">Blog</a></li>
                    <li><a href="./contact.html">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <section class="section">
            <div class="blogs wrap">
                <h2 class="section_title">
                    <p>Blog</p>
                </h2>
                <div class="author">
                    <?php if ($logout_result) : ?>
                        <p>ログアウトしました。</p>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['loginUserId']) && $logout_result === false) : ?>
                        <a href="writing.php">投稿</a>
                        <a href="?action=logout">ログアウト</a>
                    <?php else : ?>
                        <a href="./login.php">管理者用</a>
                    <?php endif; ?>
                </div>

                <?php foreach ($blogs as $blog) : ?>
                    <div class="blog">
                        <h3 class="blog_title"><?= $blog["title"]; ?></h3>
                        <div class="blog_wrap">
                            <div class="blog_img">
                                <img src="./upload/<?= $blog["img"]; ?>">
                            </div>
                            <div class="blog_content">
                                <?= $blog["text"]; ?>
                            </div>
                            <div class="blog_etc">
                                <p class="date"><?= $blog["create_time"]; ?></p>
                                <?php if (isset($_SESSION['loginUserId']) && $_SESSION['loginUserId'] === $blog['user_id']) : ?>
                                    <div class="authorOnly" data-user="<?= $blog["user_id"]; ?>" data-blog="<?= $blog["id"]; ?>">
                                        <a class="edit" href="">編集</a>
                                        <a class="delete" href="">削除</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>





    <footer class="footer">
        <div class="circle_wrap">
            <div class="circle1 circle">
                <div class="circle2 circle">
                    <div class="circle3 circle">
                        <div class="circle4 circle">
                            <div class="circle5 circle">
                                <div class="circle6 circle"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copylight">
            <p>copylight©Manabu Miyamoto | All Rights Reserved.</p>
        </div>
    </footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="./js/blog_page.js"></script>
</body>

</html>
