<?php
/**
 * 字符串相关处理。
 */
namespace util;

class Str
{

    /**
     * 生成随机字符串。
     * @param int $length 字符串长度。
     * @return string
     */
    public static function random($length, $queue = '')
    {
        if ($length < 1) {
            return false;
        }

        if ($queue) {
            $all = $queue;
        } else {
            $all = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }

        $i = 0;
        $output = '';
        $total = strlen($all) - 1;

        while ($i < $length) {
            $output .= $all{rand(0, $total)};
            $i++;
        }

        return $output;
    }

    /**
     * 将字符串的中间部分用星号代替。
     * @param string $str 要处理的字符串。
     * @param int $start_length 开头显示部分的长度。
     * @param int $end_length 结尾显示部分的长度。
     * @return string
     */
    public static function partCover($str, $start_length, $end_length, $star_limit = 20, $symbol = '*')
    {
        $limit = $start_length + $end_length - 1;

        if (!isset($str{$limit})) {
            $ret = '';

            foreach (range(1, $star_limit) as $v) {
                $ret .= $symbol;
            }

            return $ret;
        }

        $i = 0;
        $star = '';

        while ($i < $star_limit) {
            $star .= $symbol;
            $i++;
        }

        $head = '';
        $tail = '';

        $head = mb_substr($str, 0, $start_length);
        $tail = mb_substr($str, -$end_length);

        $output = $head . $star . $tail;

        return $output;
    }

    /**
     * str_split加强版。
     * @param string $p_sString 待处理字符串。
     * @param int $iLen 每步切的长度。
     * @return string
     */
    public static function strSplit($p_sString, $iLen = 1, $sEncoding = 'UTF-8')
    {
        $iStrlen = mb_strlen($p_sString, 'UTF-8');

        if ($iStrlen > $iLen || !$iLen) {
            for ($i = 0; $i < $iStrlen; $i++) {
                $aRet[] = mb_substr($p_sString, 0, $iLen, $sEncoding);
                $p_sString = mb_substr($p_sString, $iLen, $iStrlen, $sEncoding);
            }
        } else {
            $aRet = array($p_sString);
        }

        return $aRet;
    }

    /**
     * utf8字符串的反转。
     * @param string $p_sString 待翻转字符串。
     * @return string
     */
    public static function utf8Strrev($p_sString)
    {
        preg_match_all('/./us', $p_sString, $aTmp);
        return implode('', array_reverse($aTmp[0]));
    }
}

# end of this file
