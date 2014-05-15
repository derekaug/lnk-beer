<?php

/**
 * Class Http
 * class to handle HTTP methods
 */
class Http
{
    /**
     * @param string $url url to get
     * @return mixed[] results from response
     */
    public static function get($url)
    {
        $options = array(
            CURLOPT_RETURNTRANSFER => true, // return web page
            CURLOPT_HEADER => false, // don't return headers
            CURLOPT_FOLLOWLOCATION => true, // follow redirects
            CURLOPT_ENCODING => "", // handle all encodings
            CURLOPT_USERAGENT => "api-client", // who am i
            CURLOPT_AUTOREFERER => true, // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120, // timeout on connect
            CURLOPT_TIMEOUT => 120, // timeout on response
            CURLOPT_MAXREDIRS => 10, // stop after 10 redirects
            CURLOPT_SSL_VERIFYPEER => false // Disabled SSL Cert checks for now
        );

        $ch = curl_init($url);
        curl_setopt_array($ch, $options);
        $content = curl_exec($ch);
        $err = curl_errno($ch);
        $errmsg = curl_error($ch);
        $rvalue = curl_getinfo($ch);
        curl_close($ch);

        $rvalue['errno'] = $err;
        $rvalue['errmsg'] = $errmsg;
        $rvalue['content'] = $content;

        return $rvalue;
    }
}