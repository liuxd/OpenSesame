<?php
/**
 * 封装网站帐号的逻辑
 */
class Site
{

    public static function parseInfo($key)
    {
        foreach ($key as $k => $v) {
            $v = base64_decode($v);
            $tmp = [
                'display' => Str::partCover($v, 2, 1),
                'real' => $v,
            ];

            $key[$k] = $tmp;
        }

        return $key;
    }
}

# end of this file
