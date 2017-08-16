<?php

namespace model;

use core as c;

class User
{
    /**
     * Get the default password.
     * @return array
     */
    public function getDefaultPassword()
    {
        return c\Config::get('default_password');
    }

    /**
     * Get the email list.
     * @return array
     */
    public function getEmails()
    {
        return c\Config::get('often_emails');
    }
}

# end of this file
