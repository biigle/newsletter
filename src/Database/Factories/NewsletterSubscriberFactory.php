<?php

namespace Biigle\Modules\Newsletter\Database\Factories;

use Biigle\Modules\Newsletter\NewsletterSubscriber;
use Illuminate\Database\Eloquent\Factories\Factory;

class NewsletterSubscriberFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = NewsletterSubscriber::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'email' => $this->faker->unique()->email(),
        ];
    }
}
