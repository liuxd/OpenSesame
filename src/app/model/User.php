<?php

namespace model;

use core as c;

class User
{
    /**
     * 获得用户的默认使用的密码。
     * @return string
     */
    public function getDefaultPassword()
    {
        return c\Config::get('default_password');
    }

    /**
     * 获得用户的邮箱列表。
     * @return array
     */
    public function getEmails()
    {
        return c\Config::get('often_emails');
    }
}

# end of this file
