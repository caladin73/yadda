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
    }
    
    public function getTagName() {
        return $this->tagName;
    }
    public function setTagName($TagName) {
        $this->tagName = $TagName;
    }
       
    public static function create($tags) {
        
        
        
        $sql = sprintf("insert into Tags (Tagname, YaddaID) 
                        values ('%s', '%s')"
                            , $this->getCode()
                            , $this->getName()
                            , $this->getContinent()
                            , $this->getRegion()
                            , $this->getSurfacearea()
                            , $this->getIndepyear()
                            , $this->getPopulation()
                            , $this->getLifeexpectancy()
                            , $this->getGnp()
                            , $this->getGnpold()
                            , $this->getLocalname()
                            , $this->getGovernmentform()
                            , $this->getHeadofstate()
                            , $this->getCapital()
                            , $this->getCode2()
                      );

        $dbh = Model::connect();
        try {
            $q = $dbh->prepare($sql);
            $q->execute();
        } catch(PDOException $e) {
            printf("<p>Insert failed: <br />%s<br/>%s</p>\n",
                $e->getMessage(), $sql);
        }
        $dbh->query('commit');
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