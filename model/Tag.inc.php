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
    
    function __construct($TagName, $YaddaID) {
        $this->tagName = $TagName;
        $this->yaddaID = $YaddaID;
    }
    
    public static function getTagsInText($text) {
        
        return preg_grep("/^¤\w+/", explode(' ', $text));
        
      /*  if (preg_match("/(¤)/", $text)) {
            
        
            $tok = strtok($text, " ");
            $tags = array();

            while ($tok !== false) {
               // echo "Word=$tok<br />";
                $tok = strtok(" ");

                if (strpos($tok, '¤') !== false) {
             //       echo 'true';
                    array_push($tags, $tok);
                }
            //    echo "Left=$tok<br />";
            }

           // $tags = strtok($text, ' ');
        }
        return $tags;*/
    }
    
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
    
    function getYaddaID() {
        return $this->yaddaID;
    }

    function setYaddaID($YaddaID) {
        $this->yaddaID = $YaddaID;
    }
}