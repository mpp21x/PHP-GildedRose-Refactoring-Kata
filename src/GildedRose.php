<?php

namespace App;

final class GildedRose
{

    private $items = [];

    public function __construct($items)
    {
        $this->items = $items;
    }

    public function updateItems()
    {
        foreach ($this->items as $item) {
            $this->updateItem($item);
        }
    }

    protected function updateItem(Item $item): void
    {
        switch ($item->name) {
            case "Aged Brie":
                $this->updateAgedBrieQuality($item);
                break;
            case "Backstage passes to a TAFKAL80ETC concert":
                $this->updateBackstagePasses($item);
                break;
            case "Sulfuras, Hand of Ragnaros":
                break;
            case "Conjured Mana Cake":
                $this->updateConjured($item);
                break;
            default:
                $this->updateNoramlProduct($item);
        }
    }

    /**
     * @param Item $item
     */
    protected function updateAgedBrieQuality(Item $item): void
    {
        if ($item->quality >= 50) {
            return;
        }

        $item->quality = $item->quality + 1;
    }

    /**
     * @param Item $item
     */
    protected function updateBackstagePasses(Item $item): void
    {
        $item->sellIn = $item->sellIn - 1;

        if ($item->sellIn == 0) {
            $item->quality = 0;
            return;
        }

        $addQualityNumber = 0;

        $addQualityNumber++;
        if ($item->sellIn < 10) {
            $addQualityNumber++;
        }
        if ($item->sellIn < 5) {
            $addQualityNumber++;
        }

        $item->quality += $addQualityNumber;
    }

    /**
     * @param Item $item
     */
    protected function updateNoramlProduct(Item $item): void
    {
        if ($item->sellIn > 0) {
            $item->sellIn--;
        }

        $decreaseNum = $item->sellIn == 0 ? 2 : 1;
        if (($item->quality - $decreaseNum) < 0) {
            $item->quality = 0;
            return;
        }
        $item->quality = $item->quality - $decreaseNum;
    }

    protected function updateConjured(Item $item): void
    {
        if ($item->sellIn > 0) {
            $item->sellIn--;
        }

        $decreaseNum = 2;
        if (($item->quality - $decreaseNum) < 0) {
            $item->quality = 0;
            return;
        }
        $item->quality = $item->quality - $decreaseNum;
    }

}

