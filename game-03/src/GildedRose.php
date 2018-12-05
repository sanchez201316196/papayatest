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


    //region Método encargado de realizar las ventas y actualizar el inventario de los items, día a día.

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

    //endregion

    //region Métodos para desacoplar las acciones generales del sistema

    //Método encargado de verificar si la calidad se encuentra excedida, para todos los ítems en excepción de los "Ítems Sulfuros"
    public function verifyMaxQuality()
    {
        if($this->quality >= 50 && $this->name != "Sulfuras, Hand of Ragnaros")
            return false;
        else
            return true;
    }

    //Método encargado de verificar si la calidad es mayor a 0, para todos los ítems
    public function verifyQualityPositive(){
        if($this->quality <= 0)
            return false;
        else
            return true;
    }

    //Método encargado de verificar sí la fecha de caducidad de un ítem ya pasó
    public function verifySellInNegative(){
        if($this->sellIn < 0)
            return true;
        else
            return false;
    }

    // Método encargado de incrementar la calidad de los items,
    // por defecto el valor de incremento es 1
    // ( puede variar dependiendo de la implementación que se haga )
    public function qualityIncreases($val = 1)
    {
        $this->quality = $this->quality + (1*$val);
    }

    // Método encargado de decrecer el valor de los días de cada item,
    // por defecto el valor de decremento es 1
    // ( puede variar dependiendo de la implementación que se haga )
    public function decreaseSellIn($val = 1)
    {
        $this->sellIn = $this->sellIn - (1*$val);
    }

    // Método encargado de decrecer el valor de la calidad de cada item,
    // por defecto el valor de decremento es 1
    // ( puede variar dependiendo de la implementación que se haga )
    public function decreaseQuality($val = 1)
    {
        $this->quality = $this->quality - (1*$val);
    }

    // Método encargado de actualizar valores de calidad de cada item,
    // ( puede variar dependiendo de la implementación que se haga )
    public function degrades($val = 1){
        if($this->verifyQualityPositive()){
            if($this->verifySellInNegative())
                $this->decreaseQuality(2*$val);
            else
                $this->decreaseQuality($val);
        }
    }

    //endregion

    //region Actualizaciones de los items/productos de la Posada Gilded Rose

    //Item Normal
    private function ItemNormal()
    {
        $this->decreaseSellIn();
        $this->degrades();
    }

    //Item Aged Brie
    private function ItemAgedBrie()
    {
        $this->decreaseSellIn();

        $this->qualityIncreases();

        if($this->verifySellInNegative())
            if($this->verifyMaxQuality())
                $this->qualityIncreases();

    }

    //Item Sulfuras
    private function ItemSulfuras()
    {
        $this->decreaseSellIn();
        $this->decreaseQuality();
    }

    //Item Backstage Passes
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

    //Item Conjured
    private function ItemConjured()
    {
        $this->decreaseSellIn();
        $this->degrades(2);

    }

    //endregion

    //region Métodos de verificación para los ítems "Sulfuras" y "Backstage Passes"

    //Método para actualizar valores de calidad y tiempo de caducidad, de los items Sulfuras, por ser un item legendario.
    public function verifySulfuras($quality,$sellIn)
    {
        if($this->name == "Sulfuras, Hand of Ragnaros"){
            if($this->quality != $quality){
                $this->quality =  $quality;
                $this->sellIn =  $sellIn;
            }
        }
    }

    //Método para actualizar valores de calidad, de los items Backstage Passes, luego del concierto.
    public function verifyAfterTheConcert()
    {
        if($this->name == "Backstage passes to a TAFKAL80ETC concert"){
            if($this->verifySellInNegative()){
                $this->quality =  0;
            }
        }
    }

    //endregion

    //region Items de la Posada de Gilded Rose

    //Aged Brie
    //Sulfuras, Hand of Ragnaros
    //Backstage passes to a TAFKAL80ETC concert
    //Conjured Mana Cake
    //normal

    //endregion


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
