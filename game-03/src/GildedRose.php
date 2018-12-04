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


    public function sold($name)
    {
        switch ($name)
        {
            case "Aged Brie":
                $this->ItemAgedBrie();
                break;
            case "Sulfuras, Hand of Ragnaros":
                $this->ItemSulfuras();
                break;
            case "Backstage passes to a TAFKAL80ETC concert":
                $this->ItemBackstagePasses();
                break;
            case "Conjured Mana Cake":
                $this->ItemConjured();
                break;
            case "normal":
                $this->ItemNormal();
                break;
        }
    }


    public function verifyMaxQuality()
    {
        if($this->quality >= 50 && $this->name != "Sulfuras, Hand of Ragnaros")
            return false;
        else
            return true;
    }

    public function verifyQualityPositive(){
        if($this->quality <= 0)
            return false;
        else
            return true;
    }

    public function verifySellInNegative(){
        if($this->sellIn < 0)
            return true;
        else
            return false;
    }

    public function qualityIncreases($val = 1)
    {
        $this->quality = $this->quality + (1*$val);
    }

    public function decreaseSellIn($val = 1)
    {
        $this->sellIn = $this->sellIn - (1*$val);
    }

    public function decreaseQuality($val = 1)
    {
        $this->quality = $this->quality - (1*$val);
    }

    public function degrades($val = 1){
        if($this->verifyQualityPositive()){
            if($this->verifySellInNegative())
                $this->decreaseQuality(2*$val);
            else
                $this->decreaseQuality($val);
        }
    }



    private function ItemNormal()
    {
        $this->decreaseSellIn();
        $this->degrades();
    }

    private function ItemAgedBrie()
    {
        $this->decreaseSellIn();

        $this->qualityIncreases();

        if($this->verifySellInNegative())
            if($this->verifyMaxQuality())
                $this->qualityIncreases();

    }

    private function ItemSulfuras()
    {
        $this->decreaseSellIn();
        $this->decreaseQuality();
    }

    private function ItemBackstagePasses()
    {
        if($this->sellIn <= 5 && $this->sellIn >= 0){
            $this->qualityIncreases(3);
        }
        else
            if($this->sellIn <= 10 && $this->sellIn >= 0){
                $this->qualityIncreases(2);
            }
            else if($this->sellIn > 10){
                $this->qualityIncreases();
            }
            else if($this->verifySellInNegative())
                $this->quality = 0;

        $this->decreaseSellIn();


    }

    private function ItemConjured()
    {
        $this->decreaseSellIn();
        $this->degrades(2);

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

    public function verifyAfterTheConcert()
    {
        if($this->name == "Backstage passes to a TAFKAL80ETC concert"){
            if($this->sellIn < 0){
                $this->quality =  0;
            }
        }
    }





    public function tick()
    {
        $quality = $this->quality;

        $sellIn = $this->sellIn;

        if($this->verifyQualityPositive())
        {
            if($this->verifyMaxQuality())
            {
                $this->sold($this->name);
            }else{
                $this->decreaseSellIn();
            }
            $this->verifyAfterTheConcert();
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
