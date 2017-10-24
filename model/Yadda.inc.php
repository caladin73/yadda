<?php

//
// Author : Jesper Uth Krab
// Made On : Oct 23, 2017 2:48:38 PM  
//

error_reporting(E_ALL);

class Yadda {
    private $yaddaID;
    private $text;
    private $username;
    private $dateAndTime;
    private $tagList; // array
    
    function __construct($YaddaID, $Text, $Username, $DateAndTime, $TagList) {
        $this->yaddaID = $YaddaID;
        $this->text = $Text;
        $this->username = $Username;
        $this->dateAndTime = $DateAndTime;
        $this->tagList = $TagList;
    }
    
    public function getYaddaID() {
        return $this->yaddaID;
    }
    public function setYaddaID($YaddaID) {
        $this->yaddaID = $YaddaID;
    }
    
    public function getUsername() {
        return $this->username;
    }
    public function setUsername($Username) {
        $this->username = $Username;
    }
    
    public function getText() {
        return $this->text;
    }
    public function setText($Text) {
        $this->text = $Text;
    }
    
    public function getDateAndTime() {
        return $this->dateAndTime;
    }
    public function setDateAndTime($DateAndTime) {
        $this->dateAndTime = $DateAndTime;
    }
    
    public function getTagList() {
        return $this->tagList;
    }
    public function setTagList($TagList) {
        $this->tagList = $TagList;
    }
    
    public function create() {
        
    }
    
    public function retrieveMany () {
        
    }
}