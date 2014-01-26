<?php
/**
 * 帐号搜索逻辑。
 */
class Search
{

    public static function get($key)
    {
        $site_list = ConfDB::get(ConstCommon::SITE_LIST);
        $result = [];

        if ($site_list['stat']) {
            foreach ($site_list['response'] as $k => $v) {
                if (empty($key) || strpos($k, $key) !== FALSE || strpos($v, $key) !== FALSE) {
                    $tmp['info_url'] = Router::genURL('appInfo', Router::OP_PAGE, ['site_name' => $k]);
                    $tmp['goto_url'] = 'http://' . $v;
                    $result[$k] = $tmp;
                }
            }
        }

        return $result;
    }

}

# end of this file
