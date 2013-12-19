<?php
/**
 * 数学工具类
 */

class Math {

    /**
     * 计算阶乘。注：解决了大数显示问题。
     *
     * @param int $n
     * @return string
     */
    public static function jiechen($n) {
        if ($n < 0) {
            return false;
        }

        $res = [];
        $res[] = 1;

        for ($i = 1; $i <= $n; $i++) {
            $x = 0;
            $s = 0;
            $len = count($res);

            for ($j = 0; $j < $len; $j++) {
                if (!isset($res[$j])) {
                    $res[$j] = 0;
                }

                $x = $i * $res[$j] + $s; //乘积加上进位
                $res[$j] = $x % 10; //每个数组单项等于上面算得的数除以10的余数
                $s = ($x - $res[$j]) / 10; //求出进位用于下次相加

                if ($s > 0 && ($j + 1) == $len) {
                    $len++;
                }
            }
        }

        return implode(array_reverse($res), '');
    }

}

# end of this file
