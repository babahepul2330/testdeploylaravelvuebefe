<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     * 
     * @var string
     * */
    protected $model = Product::class;

    protected static $categories;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        if (self::$categories === null) {
            self::$categories = Category::all()->pluck('id')->toArray();
        }

        $name = $this->faker->word;

        return [
            'category_id' => $this->faker->randomElement(self::$categories),
            'name' => $name,
            'price' => $this->faker->numberBetween(1000, 100000),
            'description' => $this->faker->paragraph,
            'image' => "https://placehold.co/600x400?text=$name",
            'image_public_id' => Str::random(10),
            'stock' => $this->faker->numberBetween(25, 100),
        ];
    }
}
