<?php
namespace Modules\Transisi\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Transisi\Entities\Company::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->company(),
            'email' => $this->faker->unique()->safeEmail(),
            'website' =>$this->faker->unique()->url(),
        ];
    }
}

