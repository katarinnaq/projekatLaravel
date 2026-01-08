<?php

namespace Tests\Unit;

use App\Models\Product;
use Tests\TestCase;

class ProductModelTest extends TestCase
{
    public function test_product_ima_relaciju_sa_kategorijom()
    {
        $product = new Product;

        $this->assertTrue(
            method_exists($product, 'kategorija'),
            'Product nema definisanu kategorija relaciju'
        );
    }
}
