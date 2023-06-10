<?php

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
                    <div class="work">
                        <p class="w_title">ブログアプリ(Java)</p>
                        <div class="w_img_wrap">
                            <img src="./img/java_blog_app.jpg" alt="JavaBlogAppの画像">
                        </div>
                        <div class="contents">
                            <p class="skill">
                                使用したスキル：
                                <span>HTML, CSS, JavaScript, Java, SQL(H2サーバー)</span>
                            </p>
                            <p class="description">
                                JavaのサーブレットとJSPファイルを使用し、ブログアプリを作成しました。<br>
                                アカウントの登録、取得(ログイン), 削除機能。<br>
                                ブログの追加、表示、編集、削除機能。<br>
                                Ajaxを使用した「いいね」機能や、アカウントの登録済みユーザーネームのチェック機能等を実装しています。
                            </p>
                            <a href="https://github.com/miyamoto-ma/java_blog_app" target="_blank">GitHub</a>
                        </div>
                    </div>
                    <div class="work">
                        <p class="w_title">モーダルウィンドウパーツ</p>
                        <div class="w_img_wrap">
                            <img src="./img/my_modal.jpg" alt="モーダルライブラリ画像">
                        </div>
                        <div class="contents">
                            <p class="skill">
                                使用したスキル：
                                <span>HTML, CSS, JavaScript</span>
                            </p>
                            <p class="description">
                                当サイトを作成するにあたり、モーダルウィンドウをパーツ化してみました。<br>
                                画像をクリックすると開き、[×]ボタンもしくは背景をクリックすると閉じるというシンプルなものです。<br>
                                css/my_modal.cssとjs/my_modal.jsをローカルにコピーした後、
                                htmlファイルで親要素にmodalクラス、子要素にimg要素を設定するだけで実装が可能です。
                            </p>
                            <a href="./blog.php">当サイトのブログページにて実装。</a>
                            <a href="https://github.com/miyamoto-ma/simple_modal_js/tree/main" target="_blank">GitHub</a>
                        </div>
                    </div>
                    <div class="work">
                        <p class="w_title">ダミー</p>
                        <div class="w_img_wrap">
                            <img src="./img/dummy.jpg" alt="">
                        </div>
                        <div class="contents">
                            <p class="skill">
                                使用したスキル：
                                <span>HTML, CSS, JavaScript</span>
                            </p>
                            <p class="description">
                                説明文を入れる。説明文を入れる。説明文を入れる。説明文を入れる。<br>
                                <a href=""></a>
                            </p>
                            <a href="">ダミーリンク</a>
                        </div>
                    </div>
                    <div class="work">
                        <p class="w_title">ダミー</p>
                        <div class="w_img_wrap">
                            <img src="./img/dummy.jpg" alt="">
                        </div>
                        <div class="contents">
                            <p class="skill">
                                使用したスキル：
                                <span>HTML, CSS, JavaScript</span>
                            </p>
                            <p class="description">
                                説明文を入れる。説明文を入れる。説明文を入れる。説明文を入れる。
                            </p>
                            <a href="">ダミーリンク</a>
                        </div>
                    </div>
                    <div class="work">
                        <p class="w_title">ダミー</p>
                        <div class="w_img_wrap">
                            <img src="./img/dummy.jpg" alt="">
                        </div>
                        <div class="contents">
                            <p class="skill">
                                使用したスキル：
                                <span>HTML, CSS, JavaScript</span>
                            </p>
                            <p class="description">
                                説明文を入れる。説明文を入れる。説明文を入れる。説明文を入れる。
                            </p>
                            <a href="">ダミーリンク</a>
                        </div>
                    </div>
                    <div class="work">
                        <p class="w_title">ダミー</p>
                        <div class="w_img_wrap">
                            <img src="./img/dummy.jpg" alt="">
                        </div>
                        <div class="contents">
                            <p class="skill">
                                使用したスキル：
                                <span>HTML, CSS, JavaScript</span>
                            </p>
                            <p class="description">
                                説明文を入れる。説明文を入れる。説明文を入れる。説明文を入れる。
                            </p>
                            <a href="">ダミーリンク</a>
                        </div>
                    </div>
                    <div class="work">
                        <p class="w_title">ダミー</p>
                        <div class="w_img_wrap">
                            <img src="./img/dummy.jpg" alt="">
                        </div>
                        <div class="contents">
                            <p class="skill">
                                使用したスキル：
                                <span>HTML, CSS, JavaScript</span>
                            </p>
                            <p class="description">
                                説明文を入れる。説明文を入れる。説明文を入れる。説明文を入れる。
                            </p>
                            <a href="">ダミーリンク</a>
                        </div>
                    </div>
                    <div class="work">
                        <p class="w_title">ダミー</p>
                        <div class="w_img_wrap">
                            <img src="./img/plant1.jpg" alt="">
                        </div>
                        <div class="contents">
                            <p class="skill">
                                使用したスキル：
                                <span>HTML, CSS, JavaScript</span>
                            </p>
                            <p class="description">
                                説明文を入れる。説明文を入れる。説明文を入れる。説明文を入れる。
                            </p>
                            <a href="">ダミーリンク</a>
                        </div>
                    </div>
                    <div class="work">
                        <p class="w_title">ダミー</p>
                        <div class="w_img_wrap">
                            <img src="./img/dummy.jpg" alt="">
                        </div>
                        <div class="contents">
                            <p class="skill">
                                使用したスキル：
                                <span>HTML, CSS, JavaScript</span>
                            </p>
                            <p class="description">
                                説明文を入れる。説明文を入れる。説明文を入れる。説明文を入れる。
                            </p>
                            <a href="">ダミーリンク</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include './inc/footer.php'; ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="./js/works_page.js"></script>
</body>

</html>
