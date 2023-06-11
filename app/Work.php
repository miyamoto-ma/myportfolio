<?php

namespace MySite;

class Work
{
    // worksの追加
    public static function addWork($pdo, $user_id, $title, $skill, $text, $link1, $link2, $link_text1, $link_text2)
    {
        $sql = "INSERT INTO WORKS (user_id, title, skill, text, link1, link2, link_text1, link_text2) VALUES (:user_id, :title, :skill, :text, :link1, :link2, :link_text1, :link_text2)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue('user_id', $user_id, \PDO::PARAM_INT);
        $stmt->bindValue('title', $title, \PDO::PARAM_STR);
        $stmt->bindValue('skill', $skill, \PDO::PARAM_STR);
        $stmt->bindValue('text', $text, \PDO::PARAM_STR);
        $stmt->bindValue('link1', $link1, \PDO::PARAM_STR);
        $stmt->bindValue('link2', $link2, \PDO::PARAM_STR);
        $stmt->bindValue('link_text1', $link_text1, \PDO::PARAM_STR);
        $stmt->bindValue('link_text2', $link_text2, \PDO::PARAM_STR);
        $stmt->execute();
        return (int)$pdo->lastInsertId();
    }
}
