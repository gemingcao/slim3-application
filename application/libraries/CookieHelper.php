<?php
namespace App\Libraries;

class CookieHelper
{
    protected $cookiePre        = 'slim_';
    protected $cookieEncrypt    = 'T8boJ9anvC2lnudH';
    protected $cookiePath       = '/';
    protected $cookieDomain     = '';
    protected $cookieMustInt    = [];
    protected $cookieMustFilter = [];

    public function set($key, $value, $expire = 0)
    {
        $expire        = $expire > 0 ? $expire : ($value == '' ? SYS_TIME - 3600 : 0);
        $httponly      = $_SERVER['SERVER_PORT'] == '443' ? true : false;
        $key           = $this->cookiePre . $key;
        $_COOKIE[$key] = $value;
        if (is_array($value)) {
            foreach ($value as $k => $v) {
                setcookie($key . '[' . $k . ']', $this->strEncryption($v, 'ENCODE'), $expire, $this->cookiePath, $this->cookieDomain, $httponly);
            }
        } else {
            setcookie($key, $this->strEncryption($value, 'ENCODE'), $expire, $this->cookiePath, $this->cookieDomain, $httponly);
        }
    }

    public function get($key, $default = '')
    {
        $key   = $this->cookiePre . $key;
        $value = isset($_COOKIE[$key]) ? $this->strEncryption($_COOKIE[$key], 'DECODE') : $default;
        if (in_array($key, $this->cookieMustInt)) {
            $value = intval($value);
        } elseif (in_array($key, $this->cookieMustFilter)) {
            $value = $this->safeFilter($value);
        }
        return $value;
    }

    public function strEncryption($string, $operation = 'ENCODE', $key = '', $expiry = 0)
    {
        $ckey_length = 4;
        $key         = md5($key != '' ? $key : $this->cookieEncrypt);
        $keya        = md5(substr($key, 0, 16));
        $keyb        = md5(substr($key, 16, 16));
        $keyc        = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(microtime()), -$ckey_length)) : '';

        $cryptkey   = $keya . md5($keya . $keyc);
        $key_length = strlen($cryptkey);

        $string        = $operation == 'DECODE' ? base64_decode(strtr(substr($string, $ckey_length), '-_', '+/')) : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
        $string_length = strlen($string);

        $result = '';
        $box    = range(0, 255);

        $rndkey = array();
        for ($i = 0; $i <= 255; $i++) {
            $rndkey[$i] = ord($cryptkey[$i % $key_length]);
        }

        for ($j = $i = 0; $i < 256; $i++) {
            $j       = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp     = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }

        for ($a = $j = $i = 0; $i < $string_length; $i++) {
            $a       = ($a + 1) % 256;
            $j       = ($j + $box[$a]) % 256;
            $tmp     = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }

        if ($operation == 'DECODE') {
            if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
                return substr($result, 26);
            } else {
                return '';
            }
        } else {
            return $keyc . rtrim(strtr(base64_encode($result), '+/', '-_'), '=');
        }
    }

    private function safeFilter($string)
    {
        $string = str_replace('%20', '', $string);
        $string = str_replace('%27', '', $string);
        $string = str_replace('%2527', '', $string);
        $string = str_replace('*', '', $string);
        $string = str_replace('"', '&quot;', $string);
        $string = str_replace("'", '', $string);
        $string = str_replace('"', '', $string);
        $string = str_replace(';', '', $string);
        $string = str_replace('<', '&lt;', $string);
        $string = str_replace('>', '&gt;', $string);
        $string = str_replace("{", '', $string);
        $string = str_replace('}', '', $string);
        $string = str_replace('\\', '', $string);
        return $string;
    }

}
