<?php
/**
 * 推荐逻辑
 */
class Recommand
{

    public static function getRandom($site_list)
    {
        $rand_keys = array_rand($site_list, ConstCommon::RECOMMAND_ACCOUNT_NUM);

        foreach ($rand_keys as $key) {
            $tmp['name'] = $key;
            $tmp['url'] = Router::gen_url('appInfo', Router::OP_PAGE, ['site_name' => $key]);
            $random_account_keys[] = $tmp;
        }

        return $random_account_keys;
    }

}

# end of this file