<?php
require_once(__DIR__ . '/app/config.php');

use MySite\Token;
use MySite\Utils;
use MySite\Validate;

Token::createToken();

// // 戻るボタンで戻ってきた時のデータ取得
// if (isset($_SESSION["contact_data"])) {
//     $contact_data = $_SESSION["contact_data"];
// }


if (filter_input(INPUT_GET, 'action') === 'confirm') {
    Token::validateToken();
    // フォームデータの取得
    $name = Utils::h($_POST["name"]);
    $kana = Utils::h($_POST["kana"]);
    $company = Utils::h($_POST["company"]);
    $mail = Utils::h($_POST["mail"]);
    $tel = Utils::h($_POST["tel"]);
    $contents = Utils::h($_POST["contents"]);

    $name_result = Validate::validateBlankNG($name, 'お名前', 100);
    $kana_result = Validate::validateBlankNG($kana, 'フリガナ', 100);
    $company_result = Validate::validateBlankOK($company, '貴社名', 100);
    $mail_result = Validate::validateBlankNG($mail, 'メールアドレス', 30);
    $tel_result = Validate::validateBlankNG($tel, '電話番号', 30);
    $contents_result = Validate::validateBlankNG($contents, 'ご質問内容', 500);

    if (empty($mail_result)) {
        $mail_result = Validate::validateMail($mail);
    }
    if (empty($tel_result)) {
        $tel_result = Validate::validateTel($tel);
    }

    $contact_data = [];
    $contact_data["name"] = $name;
    $contact_data["kana"] = $kana;
    $contact_data["company"] = $company;
    $contact_data["mail"] = $mail;
    $contact_data["tel"] = $tel;
    $contact_data["contents"] = $contents;
    if (
        empty($name_result) &&
        empty($kana_result) &&
        empty($company_result) &&
        empty($mail_result) &&
        empty($tel_result) &&
        empty($contents_result)
    ) {
        $_SESSION["contact_data"] = $contact_data;
        header('Location: contact_conf.php');
    }
}
?>

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
    <?php include_once './inc/header.php'; ?>

    <main class="main">
        <section class="wrap section">

            <h2 class="section_title">
                <p>Contact</p>
            </h2>
            <form class="c_form" action="?action=confirm" method="post">
                <div class="f_name f_item">
                    <label for="name">
                        お名前
                        <span class="required">必須</span>
                    </label>
                    <?php if (!empty($name_result)) : ?>
                        <span class="err_msg"><?= $name_result; ?></span>
                    <?php endif; ?>
                    <input type="text" class="name input_c" name="name" maxlength="100" required value="<?= !empty($contact_data["name"]) ? $contact_data["name"] : ''; ?>">
                </div>

                <div class="f_kana f_item">
                    <label for="kana">
                        お名前(フリガナ)
                        <span class="required">必須</span>
                    </label>
                    <?php if (!empty($kana_result)) : ?>
                        <span class="err_msg"><?= $kana_result; ?></span>
                    <?php endif; ?>
                    <input type="text" class="kana input_c" name="kana" maxlength="100" required value="<?= !empty($contact_data["kana"]) ? $contact_data["kana"] : ''; ?>">
                </div>

                <div class="f_company f_item">
                    <label for="company">
                        貴社名
                    </label>
                    <?php if (!empty($company_result)) : ?>
                        <span class="err_msg"><?= $company_result; ?></span>
                    <?php endif; ?>
                    <input type="text" class="company input_c" name="company" maxlength="100" value="<?= !empty($contact_data["company"]) ? $contact_data["company"] : ''; ?>">
                </div>

                <div class="f_mail f_item">
                    <label for="mail">
                        メールアドレス
                        <span class="required">必須</span>
                    </label>
                    <?php if (!empty($mail_result)) : ?>
                        <span class="err_msg"><?= $mail_result; ?></span>
                    <?php endif; ?>
                    <input type="email" class="mail input_c" name="mail" maxlength="100" required value="<?= !empty($contact_data["mail"]) ? $contact_data["mail"] : ''; ?>">
                </div>

                <div class="f_tel f_item">
                    <label for="tel">
                        電話番号
                        <span class="required">必須</span>
                    </label>
                    <?php if (!empty($tel_result)) : ?>
                        <span class="err_msg"><?= $tel_result; ?></span>
                    <?php endif; ?>
                    <input type="tel" class="tel input_c" name="tel" maxlength="30" required value="<?= !empty($contact_data["tel"]) ? $contact_data["tel"] : ''; ?>">
                </div>

                <div class="f_contents f_item">
                    <label for="contents">
                        ご質問内容をご記入下さい(500文字以内)<span class="required">必須</span>
                        <p><span id="char_contents">0</span>/500</p>
                    </label>
                    <?php if (!empty($contents_result)) : ?>
                        <span class="err_msg"><?= $contents_result; ?></span>
                    <?php endif; ?>
                    <textarea name="contents" id="contents" cols="30" rows="10" maxlength="500" required><?= !empty($contact_data["contents"]) ? $contact_data["contents"] : ''; ?></textarea>
                </div>

                <input type="hidden" name="token" value="<?= Utils::h($_SESSION['token']); ?>">

                <div class="btns">
                    <button class="btn1 btn_anime_inout" type="submit">確認画面</button>
                    <button id="clear" class="btn1 btn_anime_inout" type="reset">クリア</button>
                </div>

            </form>
        </section>
    </main>

    <?php include './inc/footer.php'; ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="./js/contact_page.js"></script>
</body>

</html>
