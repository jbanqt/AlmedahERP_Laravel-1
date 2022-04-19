<?php

namespace Database\Factories;
use App\Models\ManufacturingMaterials;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Factories\Factory;

class ManufacturingMaterialsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = ManufacturingMaterials::class;

    public function definition()
    {
        $i = 1;
        $rm = ["To Purchase", "Available"];
        return [
            'item_code'=>$this->faker->name,
            'item_name'=>$this->faker->name,
            'category_id'=>$i,
            'item_image'=> $this->faker->sentence,
            'reorder_level'=>rand(1,100),
            'reorder_qty'=>rand(1,100),
            'rm_status'=>$rm[rand(0,1)],
            'rm_quantity'=>rand(1,100),
            'stock_quantity'=>rand(1,100),
            'consumable'=>rand(0,1),
        ];
    }
}
