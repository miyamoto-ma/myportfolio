<?php

namespace MySite;
// require_once(__DIR__ . '/functions.php');

// $pdo = getPDOInstance();
// $skills_arr = ['html', 'css', 'javascript'];
// $skills = implode(', ', $skills_arr);
// $id = addWork($pdo, 1, 'ダミー', $skills, 'ここに説明文を記述します。', 'http://localhost/ポートフォリオ2023/blogs.php', '', 'ブログページ', '');
// print $id;


// バリデートのテスト
require_once(__DIR__ . '/Validate.php');

// $mail1 = "test@test.com";
// $mail2 = "@test.com";
// $mail3 = "te-st@test.test-te1.com";
// $mail1_r = Validate::validateMail($mail1);
// $mail2_r = Validate::validateMail($mail2);
// $mail3_r = Validate::validateMail($mail3);
// print '1: ' . $mail1_r . '<br>';
// print '2: ' . $mail2_r . '<br>';
// print '3: ' . $mail3_r . '<br>';
// if (empty($mail1_r)) {
//     print '1は空です';
// }


// $tel1 = "080-0000-0000";
// $tel2 = "0880-000-0000";
// $tel3 = "0-000-0000-00000";
// $tel1_r = Validate::validateTel($tel1);
// $tel2_r = Validate::validateTel($tel2);
// $tel3_r = Validate::validateTel($tel3);
// print '1: ' . $tel1_r . '<br>';
// print '2: ' . $tel2_r . '<br>';
// print '3: ' . $tel3_r . '<br>';
