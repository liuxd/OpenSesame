<?php
/**
 * 字符串相关处理。
 * @author liuxd
 */
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
            return FALSE;
        }

        if ($queue) {
            $all = $queue;
        } else {
            $all = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }

        $i = 0;
        $output = '';

        while ($i < $length) {
            $output .= $all{rand(0, 61)};
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
    public static function part_cover($str, $start_length, $end_length, $star_limit = 20, $symbol = '*')
    {
        $limit = $start_length + $end_length - 1;

        if (!isset($str{$limit})) {
            $ret = '';

            foreach(range(1,$star_limit) as $v){
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

        $head = mb_substr($str, 0, 2);
        $tail = mb_substr($str, -1);
        $output = $head . $star . $tail;

        return $output;
    }

}

# end of this file
