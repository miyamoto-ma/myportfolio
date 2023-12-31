<?php
require_once(__DIR__ . '/app/config.php');

use MySite\Database;
use MySite\Works;
use MySite\Blog;

$pdo = Database::getPDOInstance();

// Worksの最新記事の読み込み
$works_in_page = 6;     // 読み込み数
$works = Works::getWorksByPage($pdo, 1, $works_in_page);

// Blogの最新記事のよみこみ
$blogs_in_page = 10;    // 読み込み数
$blogs = Blog::getBlogsByPage($pdo, 1, $blogs_in_page);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyPortfolio</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;1,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/destyle.min.css">
    <link rel="stylesheet" href="./css/slick.css">
    <link rel="stylesheet" href="./css/slick-theme.css">
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <?php include_once './inc/header.php'; ?>

    <main class="main">
        <section class="home_about section">
            <div class="home_about_wrap wrap">
                <h2 class="section_title">
                    <p>About</p>
                </h2>
                <div class="h_about1 h_about">
                    <div class="h_img h_img1">
                        <img src="./img/plant1.jpg" alt="">
                        <span class="parallax"></span>
                    </div>
                    <p>
                        ようこそ、当サイトをご覧いただきまして、誠にありがとうございます。<br><br>
                        当サイトは、ポートフォリオ用に作成しましたサイトです。<br><br>
                        HTML, CSS, JavaScript, PHP, SQL(MariaDB)を使用し、リセットCSSとJavaScriptライブラリ以外は一からコーディングしています。<br><br>
                        ネット上での公開となりますため、Aboutページの内容は簡易な紹介でございますが、応募の際の『履歴書』『職務経歴書』を併せてご確認いただけると幸いです。<br><br>
                        何卒よろしくお願いいたします。
                    </p>
                </div>

                <div class="h_about2 h_about">
                    <div class="h_img h_img2">
                        <img src="./img/plant2.jpg" alt="">
                        <span class="parallax"></span>
                    </div>
                    <table>
                        <tr>
                            <th>Home：</th>
                            <td>
                                このページです。<br>
                                最新のWorksやBlogを抜粋して掲載しています。
                            </td>
                        </tr>
                        <tr>
                            <th>About：</th>
                            <td>
                                自己紹介ページです。<br>
                                簡単な紹介とスキルを掲載しています。
                            </td>
                        </tr>
                        <tr>
                            <th>Works：</th>
                            <td>
                                プログラミングを使用して作成したものを掲載しています。
                            </td>
                        </tr>
                        <tr>
                            <th>Blog：</th>
                            <td>
                                日々のプログラミングの気づきや進捗などを掲載したブログです。
                            </td>
                        </tr>
                        <tr>
                            <th>Contact：</th>
                            <td>
                                お問い合わせのページです。
                            </td>
                        </tr>
                    </table>
                </div>
                <a class="to_about h_btn btn1 btn_anime_inout" href="./about.php">More</a>
            </div>
        </section>

        <section class="home_works section">
            <div class="home_works_wrap wrap">
                <h2 class="section_title">
                    <p>Works</p>
                </h2>
                <ul class="home_work_items" ontouchstart="">
                    <?php foreach ($works as $work) : ?>
                        <li class="home_work_item cube">
                            <img class="cube_img" src="./upload/<?= $work["img"] ?>" alt="">
                            <div class="over_text">
                                <p class="title"><?= $work["title"]; ?></p>
                                <p class="skill"><?= $work["skill"] ?></p>
                                <?php if ($work["link1"] !== '') : ?>
                                    <a href="<?= $work["link1"] ?>" target="_blank"><?= $work["link_text1"]; ?></a>
                                <?php endif; ?>
                                <?php if ($work["link2"] !== '') : ?>
                                    <a href="<?= $work["link2"] ?>" target="_blank"><?= $work["link_text2"]; ?></a>
                                <?php endif; ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <a class="to_works h_btn btn1 btn_anime_inout" href="./works.php">More</a>
            </div>
        </section>

        <section id="blog" class="home_blog section">
            <div class="home_blog_wrap wrap">
                <h2 class="section_title">
                    <p>Blog</p>
                </h2>
                <ul id="blog_slider" class="home_blog " ontouchstart="">
                    <?php foreach ($blogs as $blog) : ?>
                        <li class="home_blog_item">
                            <div class="blog_img" style="background-image: url('./upload/<?= $blog["img"] !== '' ? $blog["img"] : "dummy1.jpeg"; ?>')"></div>
                            <div class="over_text">
                                <p class="title"><?= $blog["title"]; ?></p>
                                <p class="text"><?= $blog["text"]; ?></p>
                                <a href="./blog_one.php?blogId=<?= $blog["id"]; ?>">ブログへ</a>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <a class="to_blog h_btn btn1 btn_anime_inout" href="./blog.php">More</a>
            </div>
        </section>
    </main>

    <?php include_once './inc/footer.php'; ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="./js/slick.min.js"></script>
    <script src="./js/main.js"></script>
</body>

</html>
