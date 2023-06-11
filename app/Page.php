<?php

namespace MySite;

class Page
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * ページナビ用のデータを取得するメソッド
     *
     * @param [str] $base: 'blog' or 'works'
     * @param [int] $items_per_page: 1ページに表示するアイテム数
     * @return array: $page_arr
     */
    public function itemsByPage($base, $items_per_page)
    {
        $page_arr = [];
        // 投稿内容をデータベースから取得
        $current_page = (int)(filter_input(INPUT_GET, 'page') ? filter_input(INPUT_GET, 'page') : 1); // 現在のページ
        switch ($base) {
            case 'blog':
                $items = Blog::getBlogsByPage($this->pdo, $current_page, $items_per_page); // ブログデータ取得
                $total_items = Blog::getTotal($this->pdo); // 総アイテム数
                break;
            case 'works':
                $items = Works::getWorksByPage($this->pdo, $current_page, $items_per_page); // ブログデータ取得
                $total_items = Works::getTotal($this->pdo); // 総アイテム数
                break;
            default:
                print 'ページデータを取得出来ませんでした。';
                exit;
        }
        $total_pages = ceil($total_items / $items_per_page); // 総ページ数
        // ページナビに表示する数値の配列を取得
        $around_pages = [];
        if ($current_page >= 1 && $current_page <= $total_pages) {
            if ($current_page >= 3) array_push($around_pages, $current_page - 2);
            if ($current_page >= 2) array_push($around_pages, $current_page - 1);
            array_push($around_pages, $current_page);
            if ($current_page <= $total_pages - 1) array_push($around_pages, $current_page + 1);
            if ($current_page <= $total_pages - 2) array_push($around_pages, $current_page + 2);
            $page_arr["current_page"] = $current_page;
            $page_arr["total_pages"] = $total_pages;
            $page_arr["around_pages"] = $around_pages;
            $page_arr["items"] = $items;
            return $page_arr;
        } else {
            header('Location: blog.php');
        }
    }
}
