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

    /**
     * @param $client_id CLIENT_KEY from Untappd API
     * @param $client_secret CLIENT_SECRET from Untappd API
     */
    public function __construct($client_id, $client_secret)
    {
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
    }

    /**
     * gest the CLIENT_KEY and CLIENT_SECRET in an array
     * @return array
     */
    private function authArray()
    {
        return array('client_id'=>$this->client_id, 'client_secret'=>$this->client_secret);
    }

    /**
     * call thepub/local endpoint of the api with passed params
     * @param array $params params to call with, required [lat,lng]
     * @return mixed|null on success, returns the api call results, null on error
     */
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