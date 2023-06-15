<?php
require_once(__DIR__ . '/app/config.php');

use MySite\Database;
use MySite\Blog;
use MySite\Works;
use MySite\Token;
use MySite\Utils;

Token::createToken();

// セッションにcontact_dataがセットされていない場合
if (!isset($_SESSION['contact_data'])) {
    print 'データが取得できませんでした。<br>';
    print '<a href="contact.php">戻る</a>';
}

$data = $_SESSION["contact_data"];
$name = $data["name"];
$kana = $data["kana"];
$company = $data["company"];
$mail = $data["mail"];
$tel = $data["tel"];
$contents = $data["contents"];

// Postで戻ってきたデータ処理
if (filter_input(INPUT_GET, 'action') === 'submit') {
    Token::validateToken();

    // 現在日時の取得
    date_default_timezone_set('Asia/Tokyo');
    $create_time = date('Y-m-d H:i:s');

    $sepa1 = str_repeat('-', 70);
    $sepa2 = str_repeat('□', 70);

    // 自動返信メール内容の準備
    $r_honbun = $name . "様\n\n"
        . "この度は、お問い合わせいただきまして、誠にありがとうございます。\n\n"
        . "以下の内容にてお問い合わせいただいております。\n"
        . $sepa1 . "\n"
        . $contents . "\n"
        . $sepa1 . "\n\n"
        . "回答の準備が出来次第、メール(" . $mail . ")にて返信させていただきますので、今しばらくお待ち下さいませ。\n\n\n"
        . $sepa2 . "\n"
        . NAME . "(" . KANA . ")\n"
        . "Email: " . EMAIL1 . "\n"
        . $sepa2;

    // 返信メールのパーツ
    $r_title = 'お問い合わせありがとうございます。';
    $r_header = 'From:' . EMAIL1;
    $r_honbun = html_entity_decode($r_honbun, ENT_QUOTES, 'UTF-8');

    // 自分へのメール内容の準備
    $honbun = "[お問い合わせフォーム]より問い合わせがありました。\n\n"
        . $sepa1 . "\n"
        . "■ 問い合わせ内容：\n"
        . $contents . "\n\n"
        . "■ 会社名：" . $company . "\n"
        . "■ 名前：" . $name . "(" . $kana . ")" . "\n"
        . "■ Email：" . $mail . "\n"
        . "■ Tel：" . $tel . "\n"
        . $sepa1 . "\n";

    // 自分へのメールのパーツ
    $title = '【要確認！】問い合わせが入っています。';
    $header = 'From:' . EMAIL2;
    $honbun = html_entity_decode($honbun, ENT_QUOTES, 'UTF-8');

    // セッションデータの削除
    unset($_SESSION["contact_data"]);

    try {
        // メール送信
        mb_language('Japanese');
        mb_internal_encoding('UTF-8');
        mb_send_mail($mail, $r_title, $r_honbun, $r_header);
        mb_send_mail(EMAIL1, $title, $honbun, $header);

        print 'メール送信が完了しました。<br>';
        print '(自動返信メールをご確認ください)<br><br>';
        print 'この度はお問い合わせをいただき、誠にありがとうございました。<br><br>';
        print '<a href="contact.php">戻る</a>';
        exit;
    } catch (Exception $e) {
        print '現在、障害により大変ご迷惑をお掛けしております。<br>';
        print '<a href="contact.php">戻る</a>';
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyPortfolioSite -Contact Confirm-</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;1,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/destyle.min.css" </head>
    <link rel="stylesheet" href="./css/login_form.css">
    <link rel="stylesheet" href="./css/confirm.css">
    <link rel="stylesheet" href="./css/contact_conf.css">

<body>
    <div class="form_wrap">
        <h2 class="form_title">お問い合わせ内容</h2>
        <div class="description">
            <p>以下の内容でよろしければ『送信』ボタンを押してください。</p>
            <p>修正する場合は『戻る』ボタンを押して修正してください。</p>
        </div>
        <form class="form" action="?action=submit" method="post">
            <div class="text">
                <p>お名前：</p>
                <p><?= $name; ?></p>
            </div>
            <div class="text">
                <p>お名前(フリガナ)：</p>
                <p><?= $kana; ?></p>
            </div>
            <?php if (!empty($company)) : ?>
                <div class="text">
                    <p>貴社名：</p>
                    <p><?= $company; ?></p>
                </div>
            <?php endif; ?>
            <div class="text">
                <p>メールアドレス：</p>
                <p><?= $mail; ?></p>
            </div>
            <div class="text">
                <p>電話番号：</p>
                <p><?= $tel; ?></p>
            </div>
            <div class="text">
                <p>ご質問内容：</p>
                <p><?= nl2br($contents); ?></p>
            </div>
            <input type="hidden" name="token" value="<?= Utils::h($_SESSION['token']); ?>">
            <div class="btns">
                <div class="btn btn1 h_btn btn_anime_inout">
                    <input type="submit" name="submit" value="送信">
                </div>
                <a class="btn btn1 h_btn btn_anime_inout" href="contact.php">戻る</a>
        </form>
    </div>
</body>

</html>
