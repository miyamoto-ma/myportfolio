<?php
require_once(__DIR__ . '/app/functions.php');
createToken();

if (isset($_POST['name']) && isset($_POST['pass'])) {
    validateToken();
    $name = h($_POST['name']);
    $pass = h($_POST['pass']);

    $pdo = getPDOInstance();
    $id = getAccount($pdo, $name, $pass);
    if (!empty($id)) {
        $_SESSION['loginUserId'] = $id;
        $_SESSION['loginUserName'] = $name;
        header('Location: writing.php');
        exit();
    } else {
        print 'アカウントが見つかりませんでした。<br>';
        print
            '<a href="login.php">ログイン画面へ</a>';
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyPortfolioSite -Blog Login-</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;1,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/destyle.min.css" </head>
    <link rel="stylesheet" href="./css/login_form.css">

<body>
    <div class="form_wrap">
        <h2 class="form_title">ログインフォーム</h2>
        <form class="form" action="" method="post">
            <div class="input">
                <label for="name">
                    ユーザー名：
                </label>
                <input type="text" name="name" maxlength="20" require>
            </div>
            <div class="input">
                <label for="pass">
                    パスワード：
                </label>
                <input type="password" name="pass" maxlength="20" require>
            </div>
            <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
            <div class="btns">
                <div class="btn btn1 h_btn btn_anime_inout">
                    <input type="submit" value="ログイン">
                </div>
                <div class="btn btn1 h_btn btn_anime_inout">
                    <input type="reset" value="クリア">
                </div>
                <a class="btn btn1 h_btn btn_anime_inout" href="blog.php">戻る</a>
            </div>
        </form>
    </div>
</body>

</html>