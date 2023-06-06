<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyPortfolioSite -Contact-</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;1,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/destyle.min.css">
    <link rel="stylesheet" href="./css/contact_page.css">
</head>

<body>
    <header class="header">
        <div class="header_wrap">
            <div class="h_title">
                <a href="./index.php">
                    <img class="icon" src="./img/icon.png" alt="">
                    <h1>MyPortfolioSite</h1>
                </a>
            </div>
            <nav class="h_nav">
                <ul>
                    <li><a href="./index.php">Home</a></li>
                    <li><a href="./about.php">About</a></li>
                    <li><a href="./works.php">Works</a></li>
                    <li><a href="./blog.php">Blog</a></li>
                    <li><a class="active" href="./contact.php">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="main">
        <section class="wrap section">

            <h2 class="section_title">
                <p>Contact</p>
            </h2>
            <form class="c_form" action="#" method="post">
                <div class="f_name f_item">
                    <label for="name">
                        お名前
                        <span class="required">必須</span>
                    </label>
                    <input type="text" class="name" name="name" maxlength="100" required>
                </div>

                <div class="f_kana f_item">
                    <label for="kana">
                        お名前(フリガナ)
                        <span class="required">必須</span>
                    </label>
                    <input type="text" class="kana" name="kana" maxlength="100" required>
                </div>

                <div class="f_company f_item">
                    <label for="company">
                        貴社名
                    </label>
                    <input type="text" class="company" name="company" maxlength="100">
                </div>

                <div class="f_mail f_item">
                    <label for="mail">
                        メールアドレス
                        <span class="required">必須</span>
                    </label>
                    <input type="email" class="mail" name="mail" maxlength="100" required>
                </div>

                <div class="f_tel f_item">
                    <label for="tel">
                        電話番号
                        <span class="required">必須</span>
                    </label>
                    <input type="tel" class="tel" name="tel" maxlength="30" required>
                </div>

                <div class="f_contents f_item">
                    <label for="contents">
                        ご質問内容をご記入下さい(500文字以内)
                    </label>
                    <textarea name="contents" id="contents" cols="30" rows="10" maxlength="500"></textarea>
                </div>

                <div class="btns">
                    <button class="btn1 btn_anime_inout" type="submit">送信</button>
                    <button class="btn1 btn_anime_inout" type="reset">クリア</button>
                </div>

            </form>
        </section>
    </main>

    <?php include './inc/footer.php'; ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="./js/about_page.js"></script>
</body>

</html>