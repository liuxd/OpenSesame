<?php
/**
 * 格式化输出变量。
 */

function see() {
    header('Conten-Type: text/html;charset=utf-8;');

    $cnt = func_num_args();
    $values = func_get_args();

    if ($cnt > 1) {
        foreach ($values as $k => $v) {
            see($v);
        }

        return;
    } else {
        $value = $values[0];
    }

    $echo = function ($value, $color, $type) {
        $len = '';

        if ($type === 'string') {
            $len = '(' . mb_strlen($value, 'UTF-8') . ')';
        }

        echo '<font color="',
            $color,
            '" style="font-family: arial;word-wrap: break-word;word-break: normal;"><b>',
            $type,
            $len,
            '</b> : ',
            $value,
            '</font><br>';
    };

    switch (TRUE) {
    case is_string($value) :
        $echo($value, 'red', 'string');
        break;

    case is_float($value) :
        $echo($value, 'BlueViolet', 'float');
        break;

    case is_int($value) :
        $echo($value, 'blue', 'int');
        break;

    case is_null($value) :
        $echo('null', 'Coral ', 'null');
        break;

    case is_bool($value) :
        $v = ($value) ? 'TRUE' : 'FALSE';
        $echo($v, 'green', 'bool');
        break;

    case is_array($value) :
        echo '<b style="font-family:arial">array</b>(', count($value), ')<div style="margin:10px 20px;font-family:arial">';

        foreach ($value as $kk => $vv) {
            echo '<font color="#555">', $kk, '</font> => ', see($vv);
        }

        echo '</div>';
        break;

    default :
        echo "<pre>";
        print_r($value);
        echo "</pre>";
        break;
    }
}

/**
 * 获得客户端IP
 * @return string
 */
function ip() {
    if (isset($HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"])) {
        $ip = $HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"];
    } elseif (isset($HTTP_SERVER_VARS["HTTP_CLIENT_IP"])) {
        $ip = $HTTP_SERVER_VARS["HTTP_CLIENT_IP"];
    } elseif (isset($HTTP_SERVER_VARS["REMOTE_ADDR"])) {
        $ip = $HTTP_SERVER_VARS["REMOTE_ADDR"];
    } elseif (getenv("HTTP_X_FORWARDED_FOR")) {
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    } elseif (getenv("HTTP_CLIENT_IP")) {
        $ip = getenv("HTTP_CLIENT_IP");
    } elseif (getenv("REMOTE_ADDR")) {
        $ip = getenv("REMOTE_ADDR");
    } else {
        $ip = "Unknown";
    }

    return $ip;
}

# end of this file
