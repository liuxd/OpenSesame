<?php
/**
 * 上传文件相关。
 *
 * @author liuxd
 */
class Upload {

    /**
     * 通过curl上传本地文件。
     * @param string $file 待上传的本地文件路径。
     * @param string $url 上传的目标URL。
     * @return mix 上传后的返回内容。
     */
    public static function curl_upload($file, $url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array('file' => '@' . $file));
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.65 Safari/537.36");
        $ret = curl_exec($ch);
        $error = curl_error($ch);

        if ($error) {
            die($error);
        }

        curl_close($ch);

        return $ret;
    }

}

# end of this file