<?php

namespace Test;

use App\GildedRose;
use App\Item;
use PHPUnit\Framework\TestCase;

class GildedRoseTest extends TestCase
{
    /** @var Item */
    private $item;

    public function testNormalProductUpdateQuality()
    {
        $this->item = new Item("foo", 1, 1);
        $items = [$this->item];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
        $this->assertSame("foo", $this->item->name);
        $this->shouldBe(0, 0);
    }

    protected function shouldBe(int $sellIn, int $quality): void
    {
        $this->assertSame($sellIn, $this->item->sellIn);
        $this->assertSame($quality, $this->item->quality);
    }
}
