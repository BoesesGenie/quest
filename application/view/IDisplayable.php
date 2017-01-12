<?php

namespace Application\View;

interface IDisplayable
{
    public function display();
    
    public function assign($name, $value);
}