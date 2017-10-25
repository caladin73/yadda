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
    private $level; // hvad niveau er det i hierciet
    
    function __construct($Text, $Username) {
        $this->text = $Text;
        $this->username = $Username;
     //TODO   $this->dateAndTime = $DateAndTime;
        //TODO$this->tagList = $TagList;
        $this->level = 0;
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
        
        $sql = "INSERT INTO Yadda (Text, Username) values (:text, :Username)";

        $dbh = Model::connect();
        try {
            $q = $dbh->prepare($sql);
            $q->bindValue(':text', $this->getText());
            $q->bindValue(':Username', $this->getUsername());
            $q->execute();
        } catch(PDOException $e) {
            printf("<p>Insert of Yadda failed: <br/>%s</p>\n",
                $e->getMessage());
        }
        $dbh->query('commit');
    }
        
    public static function createObject ($a) {
        
        // TODO aktiver Session fremfor predefined user
        //$un = $_SESSION['user'];
        $un = 'Jesper';
        
        $yadda = new Yadda($a['Text'], $un);
        return $yadda;
    }

    public static function retrieveMany () {
        
        $yaddas = array();
        $dbh = Model::connect();
        
        $sql = "SELECT * FROM view_yaddas_no_replies";
        
        try {
            $q = $dbh->prepare($sql);
            $q->execute();
            while ($row = $q->fetch()) {
                $yadda = self::createObject($row);
                array_push($yaddas, $yadda);
            }   
        } catch (PDOException $e) {
            printf("<P>No Yaddas could be displayed: <br/>%s</p>\n",
                    $e->getMessage());
        } finally {
            return $yaddas;            
        }
   
    }
    public function __toString() {
        $s=$this->getText();
        return $s;
    }

}
