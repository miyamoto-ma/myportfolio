<?php

namespace MySite;

class Utils
{
    // 埋め込む文字をエスケープする関数
    public static function h($str)
    {
        return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
    }
}
