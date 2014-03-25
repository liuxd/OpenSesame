<?php
namespace controller;

use core as c;
use util as u;
use model as m;

class Home extends Base
{
    public function run()
    {
        $sEmail = c\Config::get('user')['data']['email'];
        $aData = [
            'page_title' => 'Open Sesame',    
            'form_action_add' => c\Router::genURL('AddAccount'),
            'gravatar' => u\Gravatar::getGravatarURL($sEmail, 30),
            'site_total' => (new m\Account)->getTotal()
        ];

        return $aData;
    }

    protected function getBody()
    {
        return 'Home';
    }
}

# end of this file
