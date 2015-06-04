<?php
/**
 * Functions.
 */
namespace core;

/**
 * Show variables with good style.
 */
function see()
{
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

        if (extension_loaded('mbstring') && $type === 'string') {
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

    switch (true) {
        case is_string($value):
            $echo($value, 'red', 'string');
            break;

        case is_float($value):
            $echo($value, 'BlueViolet', 'float');
            break;

        case is_int($value):
            $echo($value, 'blue', 'int');
            break;

        case is_null($value):
            $echo('null', 'Coral ', 'null');
            break;

        case is_bool($value):
            $v = ($value) ? 'true' : 'false';
            $echo($v, 'green', 'bool');
            break;

        case is_array($value):
            echo '<b style="font-family:arial">array</b>(', count($value);
            echo ')<div style="margin:10px 20px;font-family:arial">';

            foreach ($value as $kk => $vv) {
                echo '<font color="#555">', $kk, '</font> => ', see($vv);
            }

            echo '</div>';
            break;
    }
}

/**
 * Get client IP.
 */
function getClientIP()
{
    $sIP = '';

    if (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $sIP = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $aIPs = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $sIP = array_shift($aIPs);
    } else {
        $sIP = $_SERVER['REMOTE_ADDR'];
    }

    return $sIP;
}

/**
 * Colorful echo.
 * @param string $string The string you want to show.
 * @param string $style Color theme.It can be:notic, info, error, system.
 */
function cecho($string, $style = 'info')
{
    if (PHP_SAPI !== 'cli') {
        echo $string, "\n";
        return;
    }

    $colors = [
        'info' => '1',
        'notice' => '32',
        'error' => '31',
        'system' => '34',
    ];

    $string = addslashes($string);
    $cmd = "echo \"\033[{$colors[$style]}m$string\033[0m\n\"";
    $out = array();
    exec($cmd, $out);

    if (isset($out[0])) {
        echo $out[0], "\n";
    }
}

/**
 * Run command in background.
 * @param string $cmd The command to run.
 * @param string $out The command's output file.
 * @param string $pid The command's pid file.
 */
function exb($cmd, $out, $pid)
{
    $sig = sprintf('%s > %s 2>&1 & echo $! > %s', $cmd, $out, $pid);
    exec($sig);
}

/**
 * Get the size of terminal.
 * @return array
 */
function get_console_size()
{
    $output = array();
    exec('stty size', $output);

    if (!isset($output[0])) {
        return array(
            'height' => 20,
            'width' => 20,
        );
    }

    $size = explode(' ', $output[0]);

    return [
        'height' => $size[0],
        'width' => $size[1],
    ];
}

# end of this file
