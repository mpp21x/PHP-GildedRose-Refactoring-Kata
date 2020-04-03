<?php

namespace App;

final class Item
{

    public $name;
    public $sellIn;
    public $quality;

    function __construct($name, $sellIn, $quality)
    {
        if($quality > 50){
            throw new InvalidItemQualityException();
        }
        $this->name = $name;
        $this->sellIn = $sellIn;
        $this->quality = $quality;
    }

    public function __toString()
    {
        return "{$this->name}, {$this->sellIn}, {$this->quality}";
    }
}

