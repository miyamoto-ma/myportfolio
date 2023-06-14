<?php

namespace MySite;

class Validate
{
    /**
     * validateBlankNG
     *
     * @param [string] $target: バリデーションする文字列
     * @param [string] $str: 戻り値の文章に入れる文字列
     * @param [int] $len: 〇文字以内の〇の部分の数字
     * @return string
     */
    // 100文字以内 空はだめ
    public static function validateBlankNG($target, $str, $len)
    {
        if (empty($target)) {
            return $str . 'を入力してください。';
        } elseif (mb_strlen($target) > $len) {
            return $str . 'は' . $len . '文字以内で入力してください。';
        }
    }

    // 100文字以内 空OK(引数は上と同様)
    public static function validateBlankOK($target, $str, $len)
    {
        if (mb_strlen($target) > $len) {
            return $str . 'は' . $len . '文字以内で入力してください。';
        }
    }

    // メールアドレスの形かどうかを調べる
    public static function validateMail($target)
    {
        if (preg_match('/\A[\w\-\.]+\@[\w\-\.]+\.([a-z]+)\z/', $target) == 0) {
            return 'メールアドレスを正確に入力してください。';
        }
    }

    // 電話番号の形かどうかを調べる
    public static function validateTel($target)
    {
        if (preg_match('/\A\d{2,5}-?\d{2,5}-?\d{4,5}\z/', $target) == 0) {
            return '電話番号を正確に入力してください。';
        }
    }

    /**
     * validateResultProcessing
     *
     * @param [array] $array: 上記バリデート結果の配列（バリデートOKなら、空文字が入っているはず）
     * @return $result: trueかflaseが返る。（true⇒全てのバリデートがOKだっとということ）
     */
    // バリデートの結果処理
    public static function validateResultProcessing($array)
    {
        $result = count(array_filter($array, function ($value) {
            return empty($value);
        })) === count($array);
        return $result;
    }
}
