<?php
/**
 * 推荐逻辑
 */
namespace model;

class Recommand
{

    public static function getRandom($site_list)
    {
        $rand_keys = array_rand($site_list, ConstCommon::RECOMMAND_ACCOUNT_NUM);

        foreach ($rand_keys as $key) {
            $tmp['name'] = $key;
            $tmp['url'] = Router::genURL('appInfo', Router::OP_PAGE, ['site_name' => $key]);
            $random_account_keys[] = $tmp;
        }

        return $random_account_keys;
    }

    public static function getRecommand($site_list)
    {
        uasort($site_list, function ($a, $b) {
            if ($a == $b) {
                return 0;
            }

            return ($a < $b) ? 1 : -1;
        });

        $keys = array_keys($site_list);
        $count = 0;
        $recomm = [];
        $tmp = [
            'name' => '',
            'url' => ''
        ];

        while ($count < ConstCommon::RECOMMAND_ACCOUNT_NUM && $keys) {
            $tmp['name'] = array_shift($keys);
            $tmp['url'] = Router::genURL('appInfo', Router::OP_PAGE, ['site_name' => $tmp['name']]);
            $recomm[] = $tmp;
            $count++;
        }

        return $recomm;
    }
}

# end of this file
