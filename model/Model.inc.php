<?php

require_once 'DbH.inc.php';
require_once 'ModelIf.inc.php';
require_once 'Model.inc.php';
require_once 'Authentication.inc.php';


/**
 * abstract Class Model
 * that implements ModelIf
 */
abstract class Model implements ModelIf {
    /**
     *dbh: private static singleton database connection property
     *cokieQ: private static cookie property set to true
     */
    private static $dbh;
    private static $cookieQ = true;

    /**
     * Model constructor for cookies.
     */
    public function __construct() {
        $this->areCookiesEnabled();
    }

    /**
     * @return PDO
     * singleton database connection, that checks if it has a connection before it will make one
     */
    public static function connect() {
        if (! self::$dbh) {
            self::$dbh = DbH::getDbH();
        }
        return self::$dbh;
    }

    /**
     * @return bool
     * checks if cookies are enable, if they are return true
     *if not enable try and set them
     *if error set them to false
     *finally return true or false
     */
    public static function areCookiesEnabled() {
        if (self::$cookieQ) {
            return true;
        } else {
            try {
                setcookie('foo', 'bar', time() + 3600);
                self::$cookieQ = true;

            } catch (Exception $ex) {
                self::$cookieQ = false;
            } finally {
                return self::$cookieQ;                
            }
        }
    }

    /**
     * @return mixed
     * public function implemented from ModelIf
     */
    abstract public function create();
    abstract public function update();
}