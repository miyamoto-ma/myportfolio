<?php

namespace MySite;

class Blog
{

    // ブログのすべて取得する
    public static function getBlogsAll($pdo)
    {
        $sql = "SELECT id, user_id, title, text, img, create_time FROM BLOGS ORDER BY id DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $blogs = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $blogs;
    }

    // 該当ページのブログを取得（ページネーション）
    public static function getBlogsByPage($pdo, $current_page, $items_per_page)
    {
        $start_row = ($current_page - 1) * $items_per_page;
        $end_row = $start_row + $items_per_page;
        $sql = "SELECT B.id, B.user_id, B.title, B.text, B.img, B.create_time
                FROM (SELECT * ,
                            ROW_NUMBER() OVER (ORDER BY id DESC) RN
                            FROM BLOGS) B
                            WHERE B.RN > :start_row AND B.RN <= :end_row";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue('start_row', $start_row, \PDO::PARAM_INT);
        $stmt->bindValue('end_row', $end_row, \PDO::PARAM_INT);
        $stmt->execute();
        $blogs = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $blogs;
    }

    // ブログの総数を取得
    public static function getTotal($pdo)
    {
        $sql = "SELECT COUNT(*) AS count FROM BLOGS";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $total = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $total["count"];
    }

    // ブログ1件分のユーザーIDを取得
    public static function getBlogUserId($pdo, $id)
    {
        $sql = "SELECT user_id FROM BLOGS WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue('id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $userId_arr = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!empty($userId_arr)) {
            return $userId_arr['user_id'];
        }
    }

    // ブログ1件分の情報を取得
    public static function getBlog($pdo, $id)
    {
        $sql = "SELECT id, user_id, title, text, img, create_time FROM BLOGS WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue('id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $blog_arr = $stmt->fetch(\PDO::FETCH_OBJ);
        return $blog_arr;
    }

    // ブログの投稿
    public static function addBlog($pdo, $user_id, $title, $text, $img, $create_time)
    {
        $sql = "INSERT INTO BLOGS (user_id, title, text, img, create_time) VALUES (:user_id, :title, :text, :img, :create_time)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue('user_id', $user_id, \PDO::PARAM_INT);
        $stmt->bindValue('title', $title, \PDO::PARAM_STR);
        $stmt->bindValue('text', $text, \PDO::PARAM_STR);
        $stmt->bindValue('img', $img, \PDO::PARAM_STR);
        $stmt->bindValue('create_time', $create_time, \PDO::PARAM_STR);
        $stmt->execute();
        return (int)$pdo->lastInsertId();
    }

    // ブログの更新
    public static function editBlog($pdo, $id, $title, $text, $img)
    {
        $sql = "UPDATE BLOGS SET title = :title, text = :text, img = :img WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue('title', $title, \PDO::PARAM_STR);
        $stmt->bindValue('text', $text, \PDO::PARAM_STR);
        $stmt->bindValue('img', $img, \PDO::PARAM_STR);
        $stmt->bindValue('id', $id, \PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }

    // ブログの削除
    public static function deleteBlog($pdo, $id)
    {
        $sql = "DELETE FROM BLOGS WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue('id', $id, \PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }
}
