<?php
namespace controller;

use core as c;
use model as m;

class Search extends Base
{
    public function run()
    {
        $sKeyword = $this->get('q');
        $aList = (new m\Search)->handle($sKeyword);
        $aOutput = [];

        foreach ($aList as $aAccount) {
            $aOutput[] = [
                'name' => $aAccount['name'],
                'rowid' => $aAccount['rowid'],
                'info_url' => c\Router::genURL('Detail', ['id' => $aAccount['rowid']]),
                'goto_url' => $aAccount['value']
            ];
        }

        $aData = [
            'page_title' => '搜索结果',
            'keyword' => $sKeyword,
            'total' => count($aList),
            'form_action_del' => c\Router::genURL('Delete'),
            'site_list' => $aOutput
        ];

        return $aData;
    }

    protected function getBody()
    {
        return 'Search';
    }
}

# end of this file
