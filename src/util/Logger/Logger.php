<?php
/**
 * 日志管理。
 */
namespace util;

class Logger
{
    const DEFAULT_BUFFER_SIZE = 10;
    private $sLogPath = '';
    private $iBufferSize = 0;
    private $iBufferCnt = 0;
    private $aBuffer = array();
    /**
     * @param string $sLogPath Log files path.
     * @param string $iBufferSize The buffer's capacity.
     * @return bool
     */
    public function __construct($sLogPath = 'default.log', $iBufferSize = 100)
    {
        if ($iBufferSize < self::DEFAULT_BUFFER_SIZE) {
            trigger_error('Buffer size must be bigger than ' . self::DEFAULT_BUFFER_SIZE);
            return false;
        }
        $this->sLogPath = ($sLogPath === 'default.log') ? __DIR__ . DIRECTORY_SEPARATOR . 'default.log' : $sLogPath;
        $this->iBufferSize = (int)$iBufferSize;
        return true;
    }
    /**
     * Add a log.
     * @param unkonwn $mLogInfo Log message.can be string, int, float or array.
     */
    public function log($mLogInfo)
    {
        $sMessage = '';
        if (is_array($mLogInfo)) {
            $sMessage = implode("\t", $mLogInfo);
        } else {
            $sMessage = $mLogInfo;
        }
        $this->aBuffer[] = $sMessage;
        $this->iBufferCnt++;
        if ($this->iBufferCnt === $this->iBufferSize) {
            $this->clearBuffer();
        }
    }
    /**
     * Clear the buffer data to log file.
     * @return bool
     */
    public function clearBuffer()
    {
        if (empty($this->aBuffer)) {
            return true;
        }
        $sLog = implode(PHP_EOL, $this->aBuffer) . PHP_EOL;
        $bResult = file_put_contents($this->sLogPath, $sLog, FILE_APPEND);
        if (!$bResult) {
            trigger_error('Write log failed.log file:' . $this->sLog);
        } else {
            $this->aBuffer = array();
            $this->iBufferCnt = 0;
        }
        return $bResult;
    }
    public function __destruct()
    {
        $this->clearBuffer();
    }
}
# end of this file
