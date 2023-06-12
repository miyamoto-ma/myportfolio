<?php

namespace MySite;

class Validate
{
    // 100文字以内 空はだめ
    public static function validate100BlankNG($target, $str)
    {
        if (empty($target)) {
            return $str . 'を入力してください。';
        } elseif (mb_strlen($target) > 100) {
            return $str . 'は100文字以内で入力してください。';
        } else {
            return 'OK';
        }
    }

    // 100文字以内 空OK
    public static function validate100BlankOK($target, $str)
    {
        if (mb_strlen($target) > 100) {
            return $str . 'は100文字以内で入力してください。';
        } else {
            return 'OK';
        }
    }

    // 400文字以内 空はだめ
    public static function validate400BlankNG($text, $str)
    {
        if (empty($text)) {
            return $str . 'を入力してください。';
        } elseif (mb_strlen($text) > 400) {
            return $str . 'は400文字以内で入力してください。';
        } else {
            return 'OK';
        }
    }

    // バリデートの結果処理
    public static function validateResultProcessing($result, $base, $from)
    {
        if ($result !== 'OK') {
            print $result . '<br>';
            print '<a href="' . $from . '.php?base=' . $base . '">戻る</a>';
            exit();
        }
    }
}
