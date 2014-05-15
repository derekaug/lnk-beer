<?php

/**
 * Class Untappd
 * class to implement Untappd api methods
 */
class Untappd
{
    private static $api_base = 'http://api.untappd.com/v4/';
    private $client_id = null;
    private $client_secret = null;

    public function __construct($client_id, $client_secret)
    {
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
    }

    private function authArray()
    {
        return array('client_id'=>$this->client_id, 'client_secret'=>$this->client_secret);
    }

    public function thePubLocal(array $params)
    {
        $rvalue = null;
        $auth = $this->authArray();
        $params = array_merge($params, $auth);
        $url = static::$api_base . 'thepub/local?' . http_build_query($params);
        $result = Http::get($url);
        if($result['http_code'] == 200){
            $rvalue = json_decode($result['content'], true);
        }
        return $rvalue;
    }
}