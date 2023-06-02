<?php
require_once(__DIR__ . '/app/functions.php');
createToken();

// ログインされていなければログイン画面へ
if (!isset($_SESSION['loginUser'])) {
    print 'ログインされていません<br>';
    print '<a href="login.php">ログイン画面へ</a>';
    exit();
}

if (filter_input(INPUT_GET, 'action') === 'add') {
    // フォームデータを取得
    $title = h($_POST['title']);
    $text = h($_POST['text']);
    $img = h($_POST['img']);


    // バリデート
    $title_result = validateTitle($title);
    $text_result = validateText($text);

    if ($title_result !== 'OK') {
        print $title_result . '<br>';
        print '<a href="writing.php">投稿画面へ</a>';
        exit();
    }
    if ($text_result !== 'OK') {
        print $text_result . '<br>';
        print '<a href="writing.php">投稿画面へ</a>';
        exit();
    }
    // ユーザーIDを取得
    $user_id = $_SESSION['loginUserId'];
    // 現在時刻の取得
    $create_time = date('Y-m-d H:i:s');
    // PDOインスタンス取得
    $pdo = getPDOInstance();

    // ブログ投稿処理（失敗なら0）
    $blog_id = addBlog($pdo, $user_id, $title, $text, $img, $create_time);
    if ($blog_id == 0) {
        print 'ブログ投稿処理に失敗しました。<br>';
        print '<a href="writing.php">投稿画面へ</a>';
        exit();
    }

    // セッションに追加したブログデータを格納
    $blog = [
        'user_id' => $user_id,
        'title' => $title,
        'text' => $text,
        'img' => $img,
        'create_time' => $create_time,
    ];
    $_SESSION['blog'] = $blog;
    header('Location: confirm.php');
    exit();
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
    <link rel="stylesheet" href="./css/writing_form.css">

<body>
    <div class="form_wrap">
        <h2 class="form_title">投稿フォーム</h2>
        <div class="form_welcome">
            <p>ようこそ<?= $_SESSION['loginUserName']; ?>さん</p>
            <a href="./blog.php">ブログ一覧へ</a>
        </div>
        <form class="form" action="?action=add" method="post">
            <div class="input">
                <label for="title">
                    <p>タイトル(100文字以内)：</p>
                    <p><span id="char_title">0</span>/100</p>
                </label>
                <input id="title" type="text" name="title" maxlength="100" required>
            </div>
            <div class="input">
                <label for="text">
                    <p>内容(400文字以内)：</p>
                    <p><span id="char_text">0</span>/400</p>
                </label>
                <textarea id="text" name="text" maxlength="400" required></textarea>
            </div>
            <div class="img">
                <span class="img_span">画像(任意)<span class="img_ctn">(.jpg, .jpeg, .gif画像のみ(1MB以内))</span>：</span>
                <input id="file" type="file" name="img" accept=".jpg, .jpeg, .gif">
            </div>
            <div class="preview">
                <div class="new_preview">
                    プレビュー：
                    <img id="new_img">
                </div>
            </div>
            <input type="hidden" name="token" value="<?php print $token; ?>">
            <div class="btns">
                <div class="btn btn1 h_btn btn_anime_inout">
                    <input type="submit" value="確認画面へ">
                </div>
                <div class="btn btn1 h_btn btn_anime_inout">
                    <input type="reset" value="クリア">
                </div>
            </div>
        </form>
    </div>
    <script src="./js/writing.js"></script>
</body>

</html>
