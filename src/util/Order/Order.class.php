<?php
/**
 * 排序库。
 * @author liuxd
 */
class Order {

    /**
     * 二维数组按两个字段进行排序。使用冒泡排序。
     * @param array $arr 待排序数组。
     * @param array $ord 排序因子。
     *                   例子：array(
     *                              0 => 'field1:asc',
     *                              1 => 'field2:desc',
     *                         );
     *                         表示按field1升序排序之后，在field1的值相等的情况下，再按field2降序排序。
     *                         asc,desc是固定的值，没有其他可能值。
     * @return string
     */
    public static function bubble($arr, $ord) {
        if (empty($ord) or empty($arr)) {
            return FALSE;
        }
        $len = count($arr);
        $x = $arr;

        list ($field1, $ord1) = explode(':', $ord[0]);
        list ($field2, $ord2) = explode(':', $ord[1]);

        if ($ord1 === 'asc') {
            usort($x, function($a, $b)use($field1) {
                        $r = $a[$field1] - $b[$field1];
                        return $r < 0 ? -1 : 1;
                    });
        } else {
            usort($x, function($a, $b)use($field1) {
                        $r = $a[$field1] - $b[$field1];
                        return $r > 0 ? -1 : 1;
                    });
        }

        //二维排序
        for ($j = 0; $j < $len; $j++) {
            for ($z = $j + 1; $z < $len; $z++) {
                if ($x[$j][$field1] == $x[$z][$field1]) {
                    if ($ord2 === 'desc') {
                        if ($x[$j][$field2] < $x[$z][$field2]) {
                            $tmp = $x[$j];
                            $x[$j] = $x[$z];
                            $x[$z] = $tmp;
                        }
                    } else {
                        if ($x[$j][$field2] > $x[$z][$field2]) {
                            $tmp = $x[$j];
                            $x[$j] = $x[$z];
                            $x[$z] = $tmp;
                        }
                    }
                }
            }
        }

        return $x;
    }

}

# end of this file