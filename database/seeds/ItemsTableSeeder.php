<?php

use Illuminate\Database\Seeder;

use App\Models\Admin\Item;
use App\Models\Admin\ItemProduct;
use App\Models\Admin\ItemService;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product = ItemProduct::create(['upc' => 1234]);

        $item = new Item(['sku' => 'AD200', 'name' => 'Godox AD200']);

        $product->item()->save($item);

        $product = ItemProduct::create(['upc' => 1234]);

        $item = new Item(['sku' => 'SK300_II', 'name' => 'Godox SK300-II']);

        $product->item()->save($item);

        $product = ItemProduct::create(['upc' => 1234]);

        $item = new Item(['sku' => 'SK400_II', 'name' => 'Godox SK400-II']);

        $product->item()->save($item);

        $product = ItemProduct::create(['upc' => 1234]);

        $item = new Item(['sku' => 'SL200_W', 'name' => 'Godox SL200-W']);

        $product->item()->save($item);

        $product = ItemProduct::create(['upc' => 1234]);

        $item = new Item(['sku' => 'SLB60_W', 'name' => 'Godox SLB60-W']);

        $product->item()->save($item);

        
        // Item::create(['sku' => 'AD200', 'name' => 'Godox AD200']);
        // Item::create(['sku' => 'SK300_II', 'name' => 'Godox SK300-II']);
        // Item::create(['sku' => 'SK400_II', 'name' => 'Godox SK400-II']);
        // Item::create(['sku' => 'SL200_W', 'name' => 'Godox SL200-W']);
        // Item::create(['sku' => 'SLB60_W', 'name' => 'Godox SLB60-W']);
    }
}
