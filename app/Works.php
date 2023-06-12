<?php

namespace MySite;

class Works
{
    // workの追加
    public static function addWork($pdo, $user_id, $title, $skill, $text, $img, $link1, $link2, $link_text1, $link_text2)
    {
        $sql = "INSERT INTO WORKS (user_id, title, skill, text, img, link1, link2, link_text1, link_text2) VALUES (:user_id, :title, :skill, :text, :img, :link1, :link2, :link_text1, :link_text2)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue('user_id', $user_id, \PDO::PARAM_INT);
        $stmt->bindValue('title', $title, \PDO::PARAM_STR);
        $stmt->bindValue('skill', $skill, \PDO::PARAM_STR);
        $stmt->bindValue('text', $text, \PDO::PARAM_STR);
        $stmt->bindValue('img', $img, \PDO::PARAM_STR);
        $stmt->bindValue('link1', $link1, \PDO::PARAM_STR);
        $stmt->bindValue('link2', $link2, \PDO::PARAM_STR);
        $stmt->bindValue('link_text1', $link_text1, \PDO::PARAM_STR);
        $stmt->bindValue('link_text2', $link_text2, \PDO::PARAM_STR);
        $stmt->execute();
        return (int)$pdo->lastInsertId();
    }

    // workの更新
    public static function
    editWork($pdo, $id, $title, $skill, $text, $img, $link1, $link2, $link_text1, $link_text2)
    {
        $sql = "UPDATE WORKS SET title = :title, skill = :skill, text = :text, img = :img, link1=:link1, link2 = :link2, link_text1 = :link_text1, link_text2 = :link_text2 WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue('title', $title, \PDO::PARAM_STR);
        $stmt->bindValue('skill', $skill, \PDO::PARAM_STR);
        $stmt->bindValue('text', $text, \PDO::PARAM_STR);
        $stmt->bindValue('img', $img, \PDO::PARAM_STR);
        $stmt->bindValue('link1', $link1, \PDO::PARAM_STR);
        $stmt->bindValue('link2', $link2, \PDO::PARAM_STR);
        $stmt->bindValue('link_text1', $link_text1, \PDO::PARAM_STR);
        $stmt->bindValue('link_text2', $link_text2, \PDO::PARAM_STR);
        $stmt->bindValue('id', $id, \PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }

    // worksの全てのデータを取得
    public static function getWorksAll($pdo)
    {
        $sql = "SELECT id, user_id, title, skill, text, img, link1, link2, link_text1, link_text2 FROM WORKS ORDER BY id DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $works = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $works;
    }

    // 該当ページのworkを取得（ページネーション）
    public static function getWorksByPage($pdo, $current_page, $items_per_page)
    {
        $start_row = ($current_page - 1) * $items_per_page;
        $end_row = $start_row + $items_per_page;
        $sql = "SELECT B.id, B.user_id, B.title, B.text, B.skill, B.img, B.link1, B.link2, B.link_text1, B.link_text2
                FROM (SELECT * ,
                            ROW_NUMBER() OVER (ORDER BY id DESC) RN
                            FROM WORKS) B
                            WHERE B.RN > :start_row AND B.RN <= :end_row";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue('start_row', $start_row, \PDO::PARAM_INT);
        $stmt->bindValue('end_row', $end_row, \PDO::PARAM_INT);
        $stmt->execute();
        $works = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $works;
    }

    // worksの総数を取得
    public static function getTotal($pdo)
    {
        $sql = "SELECT COUNT(*) AS count FROM WORKS";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $total = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $total["count"];
    }
}
