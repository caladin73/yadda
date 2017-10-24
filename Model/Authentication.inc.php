<?php
   require_once 'AuthA.inc.php'; // include the login parent
/*
 * Login mechanism for educational purposes.
 * Experimental
 * Should be project specific
 * Copyright nml, 2015
 */

/**
 * Description of Authentication
 * Authentication is a Singleton, hence the private constructor.
 * It is instantiated by Authentication::authenticate()
 * @author nml
 */
class Authentication extends AuthA {
    const DISPVAR = 'waldo42';
    private $name;

    private function __construct($voter, $pwd) {
        try {
            self::dbLookUp($voter, $pwd);         // invoke auth
            $_SESSION[self::SESSVAR] = $this->getEmail(); // if succesfull
            $_SESSION[self::DISPVAR] = $this->getName();   // if succesfull
        }
        catch (Exception $e) {
            self::$logInstance = NULL;
        }    
    }

    public static function authenticate($user, $pwd) {
        if (self::$logInstance === NULL) {
            self::$logInstance = new Authentication($user, $pwd);
        }
        return self::$logInstance;
    }
    
    protected function dbLookUp($user, $pwdtry) {
      // Using prepared statements to prevent SQL injection
        $db = DbH::getDbH();
        $sql = "select firstname, uid, password, activated 
                from user
                where uid = :uid
                and activated is true";
        try {
            $q = $db->prepare($sql);
            $q->bindValue(':uid', $user);
            $q->execute();
            $row = $q->fetch();
            if ($row['uid'] === $user
                    && password_verify($pwdtry, $row['password'])) { 
                $this->name = $row['firstname'];
                $this->userId = $user;
            } else {
                throw new Exception("Not authenticated", 42);
            }
        } catch(PDOException $e) {
            die($e->getMessage());
        }
    }
    
    private function getName() {
        return $this->name;
    }
    
    public static function getDispvar() {
        return $_SESSION[self::DISPVAR];
    }
}