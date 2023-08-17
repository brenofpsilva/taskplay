<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'start_date_time' => $this->faker->dateTime(),
            'end_date_time' => $this->faker->dateTime(),
            'card' => $this->faker->numberBetween($min = 1000, $max = 9000),
            'user_id' => 1,
            'list_id' => $this->faker->numberBetween($min = 1, $max = 4)
        ];
    }
}
