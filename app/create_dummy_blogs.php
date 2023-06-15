<?php

namespace MySite;

// // テスト用のブログを追加するコード（使わないときはコメントアウトしておく）
// require_once(__DIR__ . '/functions.php');

// // $blogId = addBlog($pdo, $user_id, $title, $text, $img, $create_time);

// $pdo = getPDOInstance();
// $user_id = 1;
// $title = 'dummy';
// $text = 'DummyText';
// $img = 'dummy.jpg';
// date_default_timezone_set('Asia/Tokyo');
// $create_time = date('Y-m-d H:i:s');

// for ($i = 0; $i < 10; $i++) {
//     addBlog($pdo, $user_id, $title . '_' . $i, $text . '_' . $i, $img, $create_time);
// }


require_once(__DIR__ . '/Database.php');
require_once(__DIR__ . '/Blog.php');
// ページネーションのブログが取得できたか確認
$pdo = Database::getPDOInstance();
var_dump($pdo);
$blogs = Blog::getBlogsByPage($pdo, 1, 3);
foreach ($blogs as $blog) {
    print 'blog:<br>';
    var_dump($blog);
}

// // ブログの総数が取得出来たか確認
// $pdo = getPDOInstance();
// print(getTotal($pdo));
