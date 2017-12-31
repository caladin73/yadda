<?php

/**
 * Interface ModelIf
 * properties have to be public, hence parrent class is abstract
 * two functions that create and update row in database
 */
interface ModelIf {
    public function create();
    public function update();
}