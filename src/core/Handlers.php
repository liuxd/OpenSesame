<?php
/**
 * Handlers for error, exception and so on.
 */
namespace core;

class Handlers
{
    /**
     * Handler the errors.
     * @param int $iError Error code.
     * @param string $sError Error message.
     * @param string $sErrFile The file error occurs.
     * @param string $sErrLine The line number error occurs.
     */
    public static function errorHandler($iError, $sErrStr, $sErrFile, $sErrLine)
    {
        $aMsg[] = 'NO : ' . $iError. PHP_EOL;
        $aMsg[] = 'Message : ' . strip_tags($sErrStr) . PHP_EOL;
        $aMsg[] = 'File : ' . $sErrFile. PHP_EOL;
        $aMsg[] = 'Line : ' . $sErrLine. PHP_EOL;
        $aMsg[] = 'Time : ' . date('Y-m-d H:i:s') . PHP_EOL;

        if (PHP_SAPI !== 'cli') {
            $aMsg[] = 'Request : ' . $_SERVER['REQUEST_URI'] . PHP_EOL;
            header('Content-type: text/html; charset=utf-8');

            foreach ($aMsg as $m) {
                echo '<div style="color: red"><b>', $m, '</b></div>';
            }
        } else {
            foreach ($aMsg as $m) {
                echo $m;
            }
        }

        die;
    }

    /**
     * Handle the exceptions.
     * @param Exception $exception The exception object.
     */
    public static function exceptionHandler($exception)
    {
        $aMsg[] = 'Code : ' . $exception->getCode() . PHP_EOL;
        $aMsg[] = 'Message : ' . $exception->getMessage() . PHP_EOL;
        $aMsg[] = 'File : ' . $exception->getFile() . PHP_EOL;
        $aMsg[] = 'Line : ' . $exception->getLine() . PHP_EOL;
        $aMsg[] = 'Time : ' . date('Y-m-d H:i:s') . PHP_EOL;

        if (PHP_SAPI !== 'cli') {
            $aMsg[] = 'Request : ' . $_SERVER['REQUEST_URI'] . PHP_EOL;
            header('Content-type: text/html; charset=utf-8');

            foreach ($aMsg as $m) {
                echo '<div style="color: red"><b>', $m, '</b></div>';
            }
        } else {
            foreach ($aMsg as $m) {
                echo $m;
            }
        }

        die;
    }
}

# end of this file
