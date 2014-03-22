<?php
/**
 * Gravatar头像操作类。
 */
namespace util;

class Gravatar
{

    /**
     * 获得gravata.com上的头像url。
     * @param string $email gravatar.com的帐号邮箱。
     * @param int $size 图片大小。
     * @return string
     */
    public static function getGravatarURL($email, $size)
    {
        $key = md5($email);
        $url = 'http://www.gravatar.com/avatar/' . $key . '?s=' . (int) $size . '&d=&r=G';

        return $url;
    }
}

# end of this file
