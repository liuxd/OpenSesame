<?php
namespace controller;

use core as c;
use util as u;
use model as m;

class Home extends Base
{
    public function run()
    {
        $aData = [
            'page_title' => 'Open Sesame',
            'form_action_add' => c\Router::genURL('AddAccount'),
            'site_total' => (new m\Account)->getTotal(),
            'recomm' => (new m\Recommand)->get(4)
        ];

        return $aData;
    }

    protected function getBody()
    {
        return 'Home';
    }
}

# end of this file
