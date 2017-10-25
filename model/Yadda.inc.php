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
    private $lft; // hieraci
    private $rght; // hieraci
    private $level; // hvad niveau er det i hieraciet
    private $numOfReplies;
    
    function __construct($yaddaID, $text, $username, $dateAndTime, $lft, $rght) {
        $this->yaddaID = $yaddaID;
        $this->text = $text;
        $this->username = $username;
        $this->dateAndTime = $dateAndTime;
        $this->lft = $lft;
        $this->rght = $rght;
        $this->level = 0;
        $this->numOfReplies = 0;
        $this->setTagList(Tag::getTagsInText($this->text));
    }
    
    public function getNumOfReplies() {
        return $this->numOfReplies;
    }

    public function setNumOfReplies($numOfReplies) {
        $this->numOfReplies = $numOfReplies;
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
        
        //$yaddaID, $text, $username, $dateAndTime, $lft, $rght
        $sql = "INSERT INTO Yadda (Text, Username) values (:text, :username)";

        $dbh = Model::connect();
        try {
            $q = $dbh->prepare($sql);
            $q->bindValue(':text', $this->getText());
            $q->bindValue(':username', $this->getUsername());
            
            // Get ID from inserted Yadda
            if ($q->execute() === TRUE) {
                //$lastID = $dbh->insert_id(); NO
                //$lastID = $q->insert_id(); NO
                //$lastID = mysqli_insert_id($dbh); NO
                $lastID = $dbh->lastInsertId(); 
                
                Tag::create($this->getTagList(), $lastID);
                
                $data = new test_hieraci_data(); // hieraci
                $data->rebuild_tree($lastID, 1);
            }
            $dbh->query('commit');
        } catch(PDOException $e) {
            printf("<p>Insert of Yadda failed: <br/>%s</p>\n",
                $e->getMessage());
            $dbh->query('rollback'); //TODO Tags skal ogsÃ¥ fjernes
        }
    }
        
    public static function createObject ($a) {
        
        //TODO Tjek at felterne er korrekte/udfyldte
        
        // TODO aktiver Session fremfor predefined user
        //$un = $_SESSION['user'];
        $username = 'Jesper';
        //$yaddaID, $text, $username, $dateAndTime, $lft, $rght
                
        $yadda = new Yadda(null, $a['text'], $username, null, 0, 0);
        
        //$tags = Tag::getTagsInText('Der var engang en lille Â¤prinsesse som der gerne ville have en pony Â¤pony');
        //TODO insert tags in DB
        
        
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
               // $yadda = self::createObject($row);
                //$yaddaID, $text, $username, $dateAndTime, $lft, $rght
                $yadda = new Yadda($row["YaddaID"], $row["Text"], $row["Username"], $row["DateAndTime"], $row["lft"], $row["rght"]);
                $yadda->setNumOfReplies($row["replies"]);
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
        $s = "<div class='yadda' style='position:relative;left:".($this->getLevel()*20)."px;'>\n";
            //<div class='user'> background-color:red;
            $s .= "<span class='user'>\n"
                    ."<img width='20' height='20' src='getImage.php?id=".$this->getUsername()."' />\n"
                    ."<a href='getUserProfile.php?id=".$this->getUsername()."'><b> $".$this->getUsername().": </b></a>\n</span>\n"
                    .Tag::getTextWithTagLinks($this->getText());
            
            if($this->getNumOfReplies() > 0) {
                if($this->getNumOfReplies() == 1) {
                    $s .= "<div class='reply'><a href='opendivwithreplies.js'>1 reply<a/></div>";
                } else {
                    $s .= "<div class='reply'><a href='opendivwithreplies.js'>".$this->getNumOfReplies()." replies</a></div>";
                }
            }
            
        $s .= "</div>\n";
        //str_repeat('&nbsp;&nbsp;',$this->getLevel())
        return $s;
    }
 
    function setLevel($level) {
        $this->level = $level;
    }
    
    function getLevel() {
        return $this->level;
    }
    
    public static function getChildren($parent, $level, $yaddas) {
        $dbh = Model::connect();
    
        $sql = 'SELECT y.*, (
                    SELECT  COUNT(r.YaddaID)
                    FROM    Reply r
                    WHERE   r.YaddaID = y.YaddaID
                    ) as replies
                FROM Yadda y 
                WHERE y.YaddaID in (select r.YaddaIDReply 
                from Reply r
                where r.YaddaID = '.$parent.')';
        
        $q = $dbh->prepare($sql);
        $q->execute();
            
        // retrieve all children of $parent 
        //$result = $this->link->query($sql);   

        // display each child 
        //while ($row = mysqli_fetch_array($result)) {   
        while ($row = $q->fetch()) {
            // indent and display the title of this child 
           // echo str_repeat('&nbsp;&nbsp;',$level).$row['YaddaID']."n<br />"; 
            $y = new Yadda($row["YaddaID"], $row["Text"], $row["Username"], $row["DateAndTime"], $row["lft"], $row["rght"]);
            $y->setLevel($level);
            $y->setNumOfReplies($row["replies"]);
            
          //  array_push($yaddas, $y);
            $yaddas .= str_repeat('&nbsp;&nbsp;',$y->getLevel()).$y."\n"; 
            // call this function again to display this 
            // child's children 

            return Yadda::getChildren($row['YaddaID'], $level+1, $yaddas); 
        } 
        return $yaddas;
    }
    
// $parent is the parent of the children we want to see 
// $level is increased when we go deeper into the tree, 
//        used to display a nice indented tree 
    public static function display_children($parent, $level) { 
        
        $dbh = Model::connect();
    
        $sql = 'SELECT y.YaddaID 
                FROM Yadda y 
                WHERE y.YaddaID in (select r.YaddaIDReply 
                from Reply r
                where r.YaddaID = '.$parent.')';
        
        $q = $dbh->prepare($sql);
        $q->execute();
        
        // retrieve all children of $parent 
        //$result = $this->link->query($sql);   

        // display each child 
        //while ($row = mysqli_fetch_array($result)) {   
        while ($row = $q->fetch()) {
            // indent and display the title of this child 
            echo str_repeat('&nbsp;&nbsp;',$level).$row['YaddaID']."n<br />"; 
            // call this function again to display this 
            // child's children 
            $this->display_children($row['YaddaID'], $level+1); 
        } 
    } 

    /* Er ikke sÃ¦rlig effektivt ved store trees */
    public function rebuild_tree($parent, $left) {   //TODO
        $dbh = Model::connect();
    
        $sql = 'SELECT y.YaddaID 
                FROM Yadda y 
                WHERE y.YaddaID in (select r.YaddaIDReply 
                from Reply r
                where r.YaddaID = '.$parent.')';
                
        // the right value of this node is the left value + 1   
        $right = $left+1;   

        $q = $dbh->prepare($sql);
        $q->execute();
        
        // get all children of this node   
        //$result = $this->link->query($sql);   

        /*if (!$this->link->error) { //TODO -> try-catch
            $error = $this->link->error;
        }*/

        //while ($row = mysqli_fetch_array($result)) {   
        while ($row = $q->fetch()) {
            // recursive execution of this function for each   
            // child of this node   
            // $right is the current right value, which is   
            // incremented by the rebuild_tree function   
            $right = $this->rebuild_tree($row['YaddaID'], $right);   
        }   

        $sql = 'UPDATE Yadda SET lft='.$left.', rght='.   
                                        $right.' WHERE YaddaID="'.$parent.'";';
        
        // we've got the left value, and now that we've processed   
        // the children of this node we also know the right value   
        //$result = $this->link->query();   
        $q = $dbh->prepare($sql);
        $q->execute();
        
        /*if (!$result) {
            $error = $this->link->error; //TODO -> try-catch
        }*/
        // return the right value of this node + 1   
        return $right+1;   
    } 
}