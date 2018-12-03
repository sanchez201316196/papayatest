<?php

namespace App;

class GildedRose
{
    public $name;

    public $quality;

    public $sellIn;

    public function __construct($name, $quality, $sellIn)
    {
        $this->name = $name;
        $this->quality = $quality;
        $this->sellIn = $sellIn;
    }

    public static function of($name, $quality, $sellIn) {
        return new static($name, $quality, $sellIn);
    }

    //normal
    //Aged Brie
    //Sulfuras, Hand of Ragnaros
    //Backstage passes to a TAFKAL80ETC concert
    //Conjured Mana Cake


    public function verifyQuality()
    {
        if($this->quality > 50 && $this->name != "Sulfuras, Hand of Ragnaros")
            return false;
        else
            return true;
    }

    public function degrades(){
        if($this->quality != 0){
            if($this->sellIn < 0)
                $this->quality = $this->quality - 2;
            else
                $this->quality = $this->quality - 1;
        }
    }

    public function verifyQualityPositive(){
        if($this->quality < 0)
            return false;
        else
            return true;
    }

    public function sold()
    {
//        if($this->name == "Sulfuras, Hand of Ragnaros")
//            $this->quality = $this->quality - 1;
//        else
            if($this->name == "Aged Brie" || $this->name == "Sulfuras, Hand of Ragnaros"){
                if($this->sellIn <= 10 && $this->sellIn >= 0){
                    $this->quality = $this->quality + 2;
                }
                if($this->sellIn <= 5 && $this->sellIn >= 0){
                    $this->quality = $this->quality + 1;
                }
            }
            else if($this->name == "Conjured Mana Cake"){
                $this->quality = $this->quality - 2;
            }
//            else{
//                $this->quality = $this->quality - 1;
//            }
    }

    public function verifySulfuras($quality)
    {
        if($this->name == "Sulfuras, Hand of Ragnaros"){
            if($this->quality != $quality)
                $this->quality =  $quality;
        }
    }

    public function decreaseSellIn()
    {
        $this->sellIn = $this->sellIn - 1;
    }



    public function tick()
    {
        $quality = $this->quality;
        if($this->verifyQualityPositive())
        {
            if($this->verifyQuality())
            {
                $this->sold();
            }
            $this->decreaseSellIn();
            $this->degrades();


            $this->verifySulfuras($quality);
        }




//        if ($this->name != 'Aged Brie' and $this->name != 'Backstage passes to a TAFKAL80ETC concert') {
//            if ($this->quality > 0) {
//                if ($this->name != 'Sulfuras, Hand of Ragnaros') {
//                    $this->quality = $this->quality - 1;
//                }
//                if($this->name == "Conjured Mana Cake"){
//                    $this->quality = $this->quality - 1;
//                }
//            }
//        } else {
//            if ($this->quality < 50) {
//                $this->quality = $this->quality + 1;
//
//                if ($this->name == 'Backstage passes to a TAFKAL80ETC concert') {
//                    if ($this->sellIn < 11) {
//                        if ($this->quality < 50) {
//                            $this->quality = $this->quality + 1;
//                        }
//                    }
//                    if ($this->sellIn < 6) {
//                        if ($this->quality < 50) {
//                            $this->quality = $this->quality + 1;
//                        }
//                    }
//                }
//            }
//        }
//
//        if ($this->name != 'Sulfuras, Hand of Ragnaros') {
//            $this->sellIn = $this->sellIn - 1;
//        }
//
//        if ($this->sellIn < 0) {
//            if ($this->name != 'Aged Brie') {
//                if ($this->name != 'Backstage passes to a TAFKAL80ETC concert') {
//                    if ($this->quality > 0) {
//                        if ($this->name != 'Sulfuras, Hand of Ragnaros') {
//                            $this->quality = $this->quality - 1;
//                        }
//                        if($this->name == "Conjured Mana Cake"){
//                            $this->quality = $this->quality - 1;
//                        }
//                    }
//                } else {
//                    $this->quality = $this->quality - $this->quality;
//                }
//            } else {
//                if ($this->quality < 50) {
//                    $this->quality = $this->quality + 1;
//                }
//            }
//        }

    }
}
