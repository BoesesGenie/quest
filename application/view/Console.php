<?php

namespace Application\View;

class Console implements IDisplayable
{
    private $data = array();
    
    public function display() {
        var_dump($this->data);
    }
    
    public function assign($name, $value) {
        $this->data[$name] = $value;
    }
}