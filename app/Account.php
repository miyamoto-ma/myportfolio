<?php

namespace MySite;

class Account
{
    // アカウントIDの取得
    public static function getAccount($pdo, $name, $pass)
    {
        $sql = "SELECT id FROM accounts WHERE name = :name AND pass = :pass";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue('name', $name, \PDO::PARAM_STR);
        $stmt->bindValue('pass', $pass, \PDO::PARAM_STR);
        $stmt->execute();
        $id_array = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!empty($id_array)) {
            return $id_array['id'];
        }
    }
}
