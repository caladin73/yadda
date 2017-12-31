<?php
   
require_once 'AuthA.inc.php'; // include the login parent

class Authentication extends AuthA {
    
    protected function __construct($user, $pwd) {
        parent::__construct($user);
        try {
            self::dbLookUp($user, $pwd);                        /** invoke auth*/
            $_SESSION[self::$sessvar] = $this->getUserId();     /** succes logged in*/
        }
        catch (Exception $e) {
            self::$logInstance = FALSE;
            unset($_SESSION[self::$sessvar]);                   /** if login failed, they are not logged in*/
        }      
    }
    
    public static function getUsername() {
        return $_SESSION[self::DISPVAR2];
    }

    /** if not set, we set $logInstance and return it*/
    public static function authenticate($user, $pwd) {
        if (! self::$logInstance) {
            self::$logInstance = new Authentication($user, $pwd);
        }
        return self::$logInstance;
    }

    /** looks user up in db when he login */
    protected static function dbLookUp($user, $pwd) {
        $sql = "select Username, Password 
                from Users
                where Username = :uid
                and Activated = 1;";
        $dbh = Model::connect();
        try {
            $q = $dbh->prepare($sql);
            $q->bindValue(':uid', $user);
            $q->execute();
            $row = $q->fetch();
            if (!($row['Username'] === $user
                    && password_verify($pwd, $row['Password']))) { 
                 throw new Exception("Not authenticated", 42);   /**  misery */
            }
        } catch(PDOException $e) {
            die($e->getMessage());
        }
    }
}
