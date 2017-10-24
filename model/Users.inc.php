<?php

//
// Author : Jesper Uth Krab
// Made On : Oct 23, 2017 2:25:56 PM  
//

error_reporting(E_ALL);

class Users {
    private $username;
    private $password;
    private $email;
    private $name;
    private $admin;
    private $activated;
    private $profileImage;
    
    function __construct($Username, $Password, $Email, $Name, $Admin, $Activated, $ProfileImage) {
        $this->username = $Username;
        $this->password = $Password;
        $this->email = $Email;
        $this->name = $Name;
        $this->admin = $Admin;
        $this->activated = $Activated;
        $this->profileImage = $ProfileImage;
    }

    public function getUsername() {
        return $this->username;
    }
    public function setUsername($Username) {
        $this->username = $Username;
    }

    public function getPassword() {
        return $this->password;
    }
    public function setPassword($Password) {
        $this->password = $Password;
    }
    
    public function getEmail() {
        return $this->email;
    }
    public function setEmail($Email) {
        $this->email = $Email;
    }
    
    public function getName() {
        return $this->name;
    }
    public function setName($Name) {
        $this->name = $Name;
    }
    
    public function getAdmin() {
        return $this->admin;
    }
    public function setAdmin($Admin) {
        $this->admin = $Admin;
    }
    
    public function getActivated() {
        return $this->activated;
    }
    public function setActivated($Activated) {
        $this->activated = $Activated;
    }
    
    public function getProfileImage() {
        return $this->profileImage;
    }
    public function setProfileImage($ProfileImage) {
        $this->profileImage = $ProfileImage;
    }
    
    public function create() {
        
    }
    
    public static function activateUser () {
        
    }
    
    public function retrieveMany () {
        
    }
    public function retrieveOne () {
        
    }
    
    public function createObject () {
        
    }
}