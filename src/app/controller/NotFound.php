<?php
namespace controller;

class NotFound extends Base
{
    public function run()
    {
        $aData = [
            'page_title' => 'Not Found',
        ];

        return $aData;
    }

    protected function getBody()
    {
        return 'NotFound';
    }
}

# end of this file
