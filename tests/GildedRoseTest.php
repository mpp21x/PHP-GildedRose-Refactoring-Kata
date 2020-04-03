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
        $this->createItem("foo", 1, 1);
        $this->updateQuality();
        $this->assertSame("foo", $this->item->name);
        $this->shouldBe(0, 0);
    }

    public function testProductQualityOrSellInIsNeverBeLessThenZero()
    {
        $this->createItem("foo", 0, 0);
        $this->updateQuality();
        $this->shouldBe(0, 0);
    }

    public function testProductQualityDecreaseDoubleWhenSellInIsZero()
    {
        $this->createItem("foo", 0, 2);
        $this->updateQuality();
        $this->shouldBe(0, 0);
    }

    protected function createItem(string $name, int $sellIn, int $quality)
    {
        $this->item = new Item($name, $sellIn, $quality);
    }

    protected function updateQuality(): void
    {
        $items = [$this->item];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateQuality();
    }

    protected function shouldBe(int $sellIn, int $quality): void
    {
        $this->assertSame($sellIn, $this->item->sellIn);
        $this->assertSame($quality, $this->item->quality);
    }
}
