<?php

namespace Database\Factories\Inventory;

use App\Models\Inventory\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, Product>
     */
    protected $model = Product::class;
    public function definition(): array
    {
        $name = fake()->words(4, true);
        $price = fake()->numberBetween(1000, 10000);
        return [
            //
            'name' => $name,
            'slug' => $this->uniqueSlug($name),
            'author_id' => function () {
                return \App\Models\User::factory()->create()->id;
            },
            'price' => $price,
            'sale_price' => floor($price * 0.8),
            'stock' => 10,
            'status_stock' => 'instock'
        ];
    }

    public function uniqueSlug($slug)
    {
        $slug = \Illuminate\Support\Str::slug($slug);

        $isExists = DB::table('products')->where(['slug' => $slug])->exists();
        if($isExists) {
            $slug .= " copy";
            $slug = \Illuminate\Support\Str::slug($slug);
            return $this->uniqueSlug($slug);
        }

        return $slug;
    }

    public function configure()
    {
        return $this->afterCreating(function(Product $product) {
            $product->details()->create([
                'sku' => \Illuminate\Support\Str::random(),
                'description' => fake()->paragraphs(asText: true),
                'short_description' => fake()->paragraphs(asText: true, nb: 2),
            ]);
        });
    }
}
