<?php

class Validate
{
    // 100文字以内 空はだめ
    public static function validate100($target, $str)
    {
        if (empty($target)) {
            return $str . 'を入力してください。';
        } elseif (mb_strlen($target) > 100) {
            return $str . 'は100文字以内で入力してください。';
        } else {
            return 'OK';
        }
    }

    // 400文字以内 空はだめ
    public static function validate400($text, $str)
    {
        if (empty($text)) {
            return $str . 'を入力してください。';
        } elseif (mb_strlen($text) > 400) {
            return $str . 'は400文字以内で入力してください。';
        } else {
            return 'OK';
        }
    }
}
