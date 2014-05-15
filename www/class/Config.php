<?php

/**
 * Class Config
 * class to handle bootstrapping and setting variables dependant on the environment
 */
class Config
{
    public static $root;
    public static $base_url;
    public static $body_class;
    public static $contact_to;
    public static $contact_from;
    public static $host;
    public static $port;
    public static $canonical_host;
    public static $environment;
    public static $asset_type;
    public static $current_url;
    public static $canonical_url;
    public static $init_done = false;
    public static $API_GOOGLE_MAPS;
    public static $API_UNTAPPD_KEY;
    public static $API_UNTAPPD_SECRET;
    public static $CACHE_UNTAPPD_TTL;
    public static $CENTER_LAT;
    public static $CENTER_LNG;

    /**
     * initialize the config class, setting base values
     */
    public static function init()
    {
        if (!static::$init_done) {
            static::$init_done = true;

            // get host first
            static::$host = $_SERVER['SERVER_NAME'];
            static::$port = $_SERVER['SERVER_PORT'];

            // set environment and asset time
            static::$canonical_host = 'lnk-beer.derekjaugustine.com';
            switch (static::$host) {
                case 'lnk-beer.derekjaugustine.com':
                case 'www.lnk-beer.derekjaugustine.com':
                    static::$environment = 'production';
                    static::$asset_type = 'min';
                    break;
                default:
                    static::$environment = 'development';
                    static::$asset_type = 'comb';
                    break;
            }
            static::$current_url = static::getCurrentURL();
            static::$canonical_url = static::getCanonicalURL();
            static::canonicalRedirect();

            // keys
            static::$API_GOOGLE_MAPS = getenv('MAPS_KEY');
            static::$API_UNTAPPD_KEY = getenv('UNTAPPD_KEY');
            static::$API_UNTAPPD_SECRET = getenv('UNTAPPD_SECRET');

            static::$CACHE_UNTAPPD_TTL = 40; // 100 requests per hour =  1 request every 36 seconds, round to 40 for safety

            static::$CENTER_LAT = 40.8097;
            static::$CENTER_LNG = -96.6753;

            static::$root = __DIR__ . '/../';

            static::$base_url = 'http://' . static::$host . (static::$port !== 80 ? ':' . static::$port : '') . '/';
            Session::init();
        }
    }

    /**
     * @return string returns the canonical URL
     */
    public static function getCanonicalURL()
    {
        $parsed = parse_url(static::$current_url);
        if ($parsed['host'] !== static::$canonical_host) {
            $parsed['host'] = static::$canonical_host;
        }
        return static::buildURL($parsed);
    }

    /**
     * handles redirection to canonical URL if the current host does not match
     */
    private static function canonicalRedirect()
    {
        if (static::$environment === 'production' && static::$host !== static::$canonical_host) {
            header('HTTP/1.1 301 Moved Permanently');
            header('Location: ' . static::getCanonicalURL());
            exit();
        }
    }

    /**
     * builds a URL from an array of URL parts
     * @param [] $url_parts array of URL parts to build into string
     * @return string string built from URL parts
     */
    private static function buildURL($url_parts)
    {
        // from http://www.php.net/manual/en/function.parse-url.php#106731
        $scheme = isset($url_parts['scheme']) ? $url_parts['scheme'] . '://' : '';
        $host = isset($url_parts['host']) ? $url_parts['host'] : '';
        $port = isset($url_parts['port']) ? ':' . $url_parts['port'] : '';
        $user = isset($url_parts['user']) ? $url_parts['user'] : '';
        $pass = isset($url_parts['pass']) ? ':' . $url_parts['pass'] : '';
        $pass = ($user || $pass) ? "$pass@" : '';
        $path = isset($url_parts['path']) ? $url_parts['path'] : '';
        $query = isset($url_parts['query']) ? '?' . $url_parts['query'] : '';
        $fragment = isset($url_parts['fragment']) ? '#' . $url_parts['fragment'] : '';
        return "$scheme$user$pass$host$port$path$query$fragment";
    }

    /**
     * builds the URL for the current requested page
     * @return string current page URL
     */
    public static function getCurrentURL()
    {
        // from http://css-tricks.com/snippets/php/get-current-page-url/
        $url = @($_SERVER["HTTPS"] != 'on') ? 'http://' . $_SERVER["SERVER_NAME"] : 'https://' . $_SERVER["SERVER_NAME"];
        $url .= (intval($_SERVER["SERVER_PORT"]) !== 80) ? ":" . $_SERVER["SERVER_PORT"] : "";
        $url .= $_SERVER["REQUEST_URI"];
        return $url;
    }
}

// initialize Config if it's loaded and not initialize (probably will get called twice, for safety)
Config::init();