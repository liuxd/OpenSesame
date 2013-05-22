<?php
/**
 * 数组相关。
 */

class Arr {
    public static function obj2arr($obj){
        if (is_array($obj) || is_object($obj)){
            $result = array();

            foreach ($obj as $key => $value){
                $result[$key] = self::obj2arr($value);
            }

            return $result;
        }

        return $obj;
    }
}

# end of this file
