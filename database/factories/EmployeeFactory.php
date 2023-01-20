<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Company;
use App\Models\Employee;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition() {
		return [
		'company_id' => Company::all()->random()->id,
		'name' => fake()->name(),
		'email' => fake()->unique()->safeEmail(),
		'phone' => fake()->phoneNumber(),
		];
	}

}
