<?php

namespace Test;

use App\GildedRose;
use App\InvalidItemQualityException;
use App\Item;
use PHPUnit\Framework\TestCase;

class GildedRoseTest extends TestCase
{
    /** @var Item */
    private $item;

    public function testNormalProductUpdateQuality()
    {
        $this->createItem("foo", 1, 1);
        $this->updateItems();
        $this->assertSame("foo", $this->item->name);
        $this->shouldBe(0, 0);
    }

    public function testProductQualityOrSellInIsNeverBeLessThenZero()
    {
        $this->createItem("foo", 0, 0);
        $this->updateItems();
        $this->shouldBe(0, 0);
    }

    public function testProductQualityDecreaseDoubleWhenSellInIsZero()
    {
        $this->createItem("foo", 0, 2);
        $this->updateItems();
        $this->shouldBe(0, 0);
    }

    public function testAgedBrieUpdateQualityIsAlwaysIncrease()
    {
        $this->createItem("Aged Brie", 0, 2);
        $this->updateItems();
        $this->shouldBe(0, 3);
    }

    public function testProductQualityNeverGreaterThen_51()
    {
        $this->expectException(InvalidItemQualityException::class);
        $this->createItem("foo", 0, 51);

        $this->createItem("Aged Brie", 0, 50);
        $this->updateItems();
        $this->shouldBe(0, 50);
    }

    public function testSulfurasSellInQuality()
    {
        $this->createItem("Sulfuras, Hand of Ragnaros", 3, 3);
        $this->updateItems();
        $this->shouldBe(3, 3);
    }

    public function testBackstagePassesQualityWhenSellInIsLessThanTenDay()
    {
        $expectedSellIn = 10;
        $this->createItem("Backstage passes to a TAFKAL80ETC concert", $expectedSellIn, 0);
        $exceptedQuality = 2;

        $exceptedSellIns = range($expectedSellIn, 6);
        foreach ($exceptedSellIns as $expectedSellIn) {
            $this->updateItems();
            $expectedSellIn--;

            $this->shouldBe($expectedSellIn, $exceptedQuality);
            $exceptedQuality += 2;
        }
    }

    public function testBackstagePassesQualityWhenSellInIsLessThanFiveDay()
    {
        $expectedSellIn = 5;
        $this->createItem("Backstage passes to a TAFKAL80ETC concert", $expectedSellIn, 0);
        $exceptedQuality = 3;

        $exceptedSellIns = range($expectedSellIn, 2);
        foreach ($exceptedSellIns as $expectedSellIn) {
            $this->updateItems();
            $expectedSellIn--;
            $this->shouldBe($expectedSellIn, $exceptedQuality);
            $exceptedQuality += 3;
        }
    }

    public function testBackstagePassesQualityIsZeroWhenSellInIsZero()
    {
        $this->createItem("Backstage passes to a TAFKAL80ETC concert", 1, 30);
        $this->updateItems();
        $this->shouldBe(0, 0);
    }

    public function testConjuredUpdateQuality()
    {
        $this->createItem("Conjured Mana Cake", 2, 20);
        $this->updateItems();
        $this->shouldBe(1, 18);
    }

    public function testBackstagePassesQualityNeverGreaterThen_51()
    {
        $this->createItem("Backstage passes to a TAFKAL80ETC concert", 15, 50);
        $this->updateItems();
        $this->shouldBe(14, 50);

        $this->createItem("Backstage passes to a TAFKAL80ETC concert", 9, 49);
        $this->updateItems();
        $this->shouldBe(8, 50);

        $this->createItem("Backstage passes to a TAFKAL80ETC concert", 4, 49);
        $this->updateItems();
        $this->shouldBe(3, 50);
    }

    protected function createItem(string $name, int $sellIn, int $quality)
    {
        $this->item = new Item($name, $sellIn, $quality);
    }

    protected function updateItems(): void
    {
        $items = [$this->item];
        $gildedRose = new GildedRose($items);
        $gildedRose->updateItems();
    }

    protected function shouldBe(int $sellIn, int $quality): void
    {
        $this->assertSame($sellIn, $this->item->sellIn);
        $this->assertSame($quality, $this->item->quality);
    }
}
