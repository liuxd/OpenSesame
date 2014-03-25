<?php
namespace model;

use core as c;

class Secure
{
    public function checkIp()
    {
        $sIP = c\ip();
        $aIP = c\Config::get('allow_ip')['data'];
        $ret = true;

        if (!in_array($sIP, $aIP)) {
            $ret = false;
        }

        return $ret;
    }
}

# end of this file
