<?php
namespace controller;

class Search extends Base
{
    public function handle()
    {
        $aData = [
            'data' => ['title' => 'hahahahh'],
            'html' => ['Search.html']
        ];

        return $aData;
    }
}

# end of this file
