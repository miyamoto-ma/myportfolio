<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyPortfolioSite -About-</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;1,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/destyle.min.css">
    <link rel="stylesheet" href="./css/about_page.css">
</head>

<body>
    <?php include_once './inc/header.php'; ?>

    <main class="main">
        <!-- 自己紹介 -->
        <section class="about section">
            <div class="about_1_wrap wrap">
                <h2 class="section_title">
                    <p>About me</p>
                </h2>
                <div class="about_1_content">
                    <div id="shadow" class="shadow">
                        <img src="./img/portfolio.jpg" alt="">
                    </div>
                    <p>
                        自己紹介します。自己紹介します。自己紹介します。自己紹介します。自己紹介します。自己紹介します。自己紹介します。自己紹介します。自己紹介します。自己紹介します。自己紹介します。自己紹介します。自己紹介します。自己紹介します。自己紹介します。自己紹介します。自己紹介します。自己紹介します。自己紹介します。自己紹介します。自己紹介します。自己紹介します。
                    </p>
                </div>
            </div>

            <!-- スキル -->
            <div class="about_2_wrap wrap">
                <h2 class="section_title">
                    <p>Skill</p>
                </h2>
                <div class="about_2_content">
                    <ul class="skills">
                        <li>
                            <h3>HTML5 & CSS3</h3>
                            <p>説明文を入れる。説明文を入れる。説明文を入れる。説明文を入れる。</p>
                        </li>
                        <li>
                            <h3>JavaScript</h3>
                            <p>説明文を入れる。説明文を入れる。説明文を入れる。説明文を入れる。</p>
                        </li>
                        <li>
                            <h3>PHP</h3>
                            <p>説明文を入れる。説明文を入れる。説明文を入れる。説明文を入れる。</p>
                        </li>
                        <li>
                            <h3>Ruby</h3>
                            <p>説明文を入れる。説明文を入れる。説明文を入れる。説明文を入れる。</p>
                        </li>
                        <li>
                            <h3>Java</h3>
                            <p>説明文を入れる。説明文を入れる。説明文を入れる。説明文を入れる。</p>
                        </li>
                        <li>
                            <h3>SQL</h3>
                            <p>説明文を入れる。説明文を入れる。説明文を入れる。説明文を入れる。</p>
                        </li>
                    </ul>
                    <div class="chart"><canvas id="myRadarChart" width="400" height="400"></canvas></div>

                </div>
            </div>
        </section>
    </main>

    <?php include './inc/footer.php'; ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.js"></script>
    <script src="./js/about_page.js"></script>
</body>

</html>
