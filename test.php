<?php

require_once(__DIR__ . '/app/config.php');

use MySite\Database;
use MySite\Blog;
use MySite\Page;
use MySite\Token;
use MySite\Utils;

Token::createToken();
$pdo = Database::getPDOInstance();


$items = Blog::getBlogsByPage($pdo, 1, 3);
// $items = Blog::getBlogsAll($pdo);
var_dump($items);
