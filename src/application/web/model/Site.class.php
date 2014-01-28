<?php
/**
 * 封装网站帐号的逻辑
 */
namespace model;

use system as s;
use utility as u;

class Site
{

    public static function parseInfo($key)
    {
        foreach ($key as $k => $v) {
            $v = base64_decode($v);
            $tmp = [
                'display' => u\Str::partCover($v, 2, 1),
                'real' => $v,
            ];

            if (substr($v, 0, 5) === 'link:') {
                $site_name = substr($v, 5);
                $tmp['link'] = s\Router::genURL('appInfo', s\Router::OP_PAGE, ['site_name' => $site_name]);
                $tmp['site_name'] = $site_name;
            }

            $key[$k] = $tmp;
        }

        return $key;
    }
}

# end of this file
