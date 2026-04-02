<?php

namespace Tests\Unit;

use App\Models\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function test_add_stock_calls_increment_with_correct_arguments()
    {
        $amount = 7;

        $product = $this->getMockBuilder(Product::class)
                        ->onlyMethods(['increment'])
                        ->getMock();

        $product->expects($this->once())
                ->method('increment')
                ->with('stok_saat_ini', $amount);

        $product->addStock($amount);
    }

    public function test_reduce_stock_decrements_and_returns_true_when_enough_stock()
    {
        $amount = 4;

        $product = $this->getMockBuilder(Product::class)
                        ->onlyMethods(['decrement'])
                        ->getMock();

        $product->stok_saat_ini = 10;

        $product->expects($this->once())
                ->method('decrement')
                ->with('stok_saat_ini', $amount);

        $this->assertTrue($product->reduceStock($amount));
    }

    public function test_reduce_stock_does_not_decrement_and_returns_false_when_insufficient_stock()
    {
        $amount = 5;

        $product = $this->getMockBuilder(Product::class)
                        ->onlyMethods(['decrement'])
                        ->getMock();

        $product->stok_saat_ini = 2;

        $product->expects($this->never())
                ->method('decrement');

        $this->assertFalse($product->reduceStock($amount));
    }
}
