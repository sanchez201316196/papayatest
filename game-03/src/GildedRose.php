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
        if($this->quality >= 50 && $this->name != "Sulfuras, Hand of Ragnaros")
            return false;
        else
            return true;
    }

    public function degrades(){
        if($this->verifyQualityPositive()){
            if($this->sellIn < 0)
                $this->quality = $this->quality - 2;
            else
                $this->quality = $this->quality - 1;
        }
    }

    public function verifyQualityPositive(){
        if($this->quality <= 0)
            return false;
        else
            return true;
    }

    public function sold($name)
    {
        switch ($name)
        {
            case "Aged Brie":
                $this->quality = $this->quality + 1;
                if($this->sellIn < 0){
                    if($this->verifyQuality()){
                        $this->quality = $this->quality + 1;
                    }
                }
                break;
            case "Sulfuras, Hand of Ragnaros":
                $this->quality = $this->quality - 1;
                break;
            case "Backstage passes to a TAFKAL80ETC concert":
                if($this->sellIn <= 5 && $this->sellIn >= 0){
                    $this->quality = $this->quality + 3;
                }
                else
                    if($this->sellIn <= 10 && $this->sellIn >= 0){
                        $this->quality = $this->quality + 2;
                    }
                    else if($this->sellIn < 0)
                        $this->quality = 0;

                break;
            case "Conjured Mana Cake":
                $this->quality = $this->quality - 2;
                break;
            case "normal":
                $this->degrades();
                break;
        }
    }

    public function verifySulfuras($quality,$sellIn)
    {
        if($this->name == "Sulfuras, Hand of Ragnaros"){
            if($this->quality != $quality){
                $this->quality =  $quality;
                $this->sellIn =  $sellIn;
            }
        }
    }

    public function decreaseSellIn()
    {
        $this->sellIn = $this->sellIn - 1;
    }



    public function tick()
    {
        $quality = $this->quality;
        $sellIn = $this->sellIn;
        if($this->verifyQualityPositive())
        {
            $this->decreaseSellIn();
            if($this->verifyQuality())
            {
                $this->sold($this->name);
            }
//            $this->degrades();
            $this->verifySulfuras($quality,$sellIn);
        }
        else{
            $this->decreaseSellIn();
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
