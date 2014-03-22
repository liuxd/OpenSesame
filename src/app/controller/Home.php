<?php
namespace controller;

use core as c;
use util as u;

class Home extends Base
{
    public function run()
    {
        $sEmail = c\Config::get('user')['data']['email'];
        $aData = [
            'page_title' => 'Open Sesame',    
            'form_action_add' => c\Router::genURL('Add'),
            'gravatar' => u\Gravatar::getGravatarURL($sEmail, 30),
            'site_total' => 0
        ];

        return $aData;
    }

    protected function getBody()
    {
        return 'Home';
    }
}

# end of this file
