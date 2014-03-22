<?php
namespace controller;

use core as c;

class Search extends Base
{
    public function run()
    {
        $aData = [
            'page_title' => '',
            'keyword' => 'sdf',
            'total' => '',
            'form_action_del' => '',
        ];

        return $aData;
    }

    protected function getBody()
    {
        return 'Search';
    }
}

# end of this file
