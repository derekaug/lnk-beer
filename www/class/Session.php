<?php

/**
 * Class Session
 * handles sessions
 */
class Session
{
    /**
     * initializes session, sets the name and lengths
     */
    public static function init()
    {
        $session_length = 60 * 60 * 24; // 1 day for how long session will last
        $session_regenerate_length = 60 * 15; // regenerate session id every 15 minutes

        ini_set('session.name', 'BEERSESSION');
        ini_set('session.cookie_lifetime', 0);
        ini_set('session.gc_maxlifetime', $session_length);

        session_start();
        if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $session_length)) {
            session_unset();
            session_destroy();
        }
        $_SESSION['LAST_ACTIVITY'] = time();

        if (!isset($_SESSION['CREATED'])) {
            $_SESSION['CREATED'] = time();
        } else {
            if (time() - $_SESSION['CREATED'] > $session_regenerate_length) {
                session_regenerate_id(true);
                $_SESSION['CREATED'] = time();
            }
        }
        session_write_close();

        // don't set session cookies again when calling session_start again
        ini_set('session.use_only_cookies', false);
        ini_set('session.use_cookies', false);
        ini_set('session.cache_limiter', null);
    }

    /**
     * start a session / or restart
     */
    public static function start(){
        session_start();
    }

    /**
     * close writing to session to prevent waiting
     */
    public static function writeClose(){
        session_write_close();
    }

    /**
     * @param string $key key to get
     * @return mixed|null value of session key
     */
    public static function get($key){
        return empty($_SESSION[$key]) ? null : $_SESSION[$key];
    }

    /**
     * @param string $key key to set
     * @param mixed $value value to set
     */
    public static function set($key, $value){
        $_SESSION[$key] = $value;
    }
}