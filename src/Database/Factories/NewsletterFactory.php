<?php

namespace Biigle\Modules\Newsletter\Database\Factories;

use Biigle\Modules\Newsletter\Newsletter;
use Illuminate\Database\Eloquent\Factories\Factory;

class NewsletterFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Newsletter::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'body' => $this->faker->text(),
            'subject' => $this->faker->sentence(),
        ];
    }
}
