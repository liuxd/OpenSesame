<?php

namespace controller;

class Detail extends Base
{
    public function run()
    {
        $aData = [
            'page_title' => '',
            'app'
        ];

        return $aData;
    }

    protected function getBody()
    {
        return 'Detail';
    }
}

# end of this file
