<?php

/* 
 * view/YaddaView.inc.php
 * @Project: YaddaYaddaYadda
 * @Author: Daniel, Jesper, Marianne & Peter
 */

require_once 'view/View.inc.php';

class YaddaView extends View {
    
    public function __construct($model) {
        parent::__construct($model);
    }
    
    private function displayManyYaddas() {
        $yaddas = Yadda::retrievem();
        $s = "<div class='haves'>";
        foreach ($yaddas as $yadda) {
            $s .=  sprintf("%s<br/>\n"
                , $yadda);
        }
        $s .= "</div>";
        return $s;
    }
    
    private function yaddaForm() {
        $s = sprintf("
            <form action='%s?f=U' method='post'>\n
            <div class='gets'>\n
                <h3>Post a Yadda &trade;!</h3>\n
                <p>\n
                    Message:<br/>
                    <input type='text' name='text'/>\n
                </p>\n
                <p>\n
                    <input type='submit' value='Go'/>
                </p>
            </div>", $_SERVER['PHP_SELF']);
        
        $s .= "          </div>\n";
        $s .= "          </form>\n";
        return $s;
    }
    
    public function display() {
        $this->output($this->yaddaForm());
    }
    
}
