<?php

//
// Author : Jesper Uth Krab
// Made On : Oct 23, 2017 2:56:07 PM  
//

error_reporting(E_ALL);

require_once 'Tag.inc.php';

class Tag {
    private $tagName;
    private $yaddaID;
    
    public function getTagName() {
        return $this->tagName;
    }
    public function setTagName($TagName) {
        $this->tagName = $TagName;
    }
       
    public function create() {
        
    }
    
    public function getTag () {
        
    }
    
    public function retrieveMany () {
        
    }
    
    public function createObject () {
        
    }
    
    function __construct($TagName, $YaddaID) {
        $this->tagName = $TagName;
        $this->yaddaID = $YaddaID;
    }
    function getYaddaID() {
        return $this->yaddaID;
    }

    function setYaddaID($YaddaID) {
        $this->yaddaID = $YaddaID;
    }
}