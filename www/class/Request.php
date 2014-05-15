<?php

/**
 * Class Request
 * handles getting information from the request sent to the server
 */
class Request
{
    /**
     * gets a variable from the request
     * @param string $name variable to get
     * @return null|mixed value for request variable
     */
    public static function get($name){
        return !isset($_REQUEST[$name]) ? null : $_REQUEST[$name];
    }

    /**
     * gets and sanitizes a variable from the request
     * @param string $name variable to get
     * @return null|mixed value for request variable
     */
    public static function getSanitized($name){
        $rvalue = static::get($name);
        if (is_array($rvalue)) {
            // if is array, sanitize each item in array (not recursive)
            foreach ($rvalue as &$v) {
                $v = htmlspecialchars($v, ENT_COMPAT, 'UTF-8', false);
            }
            unset($v);
        } else {
            $rvalue = htmlspecialchars($rvalue, ENT_COMPAT, 'UTF-8', false);
        }
        return $rvalue;
    }

    /**
     * gets request variable and converts to an integer
     * @param string $name variable to get
     * @return null|mixed value for request variable
     */
    public static function getInteger($name){
        return intval(static::get($name), 10);
    }

    /**
     * gets request variable and converts to an boolean
     * @param string $name variable to get
     * @return null|mixed value for request variable
     */
    public static function getBoolean($name){
        return boolval(static::get($name));
    }
} 