<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Company;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
	protected $model = Company::class;

	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition() {
		$logos = Storage::disk('local')->files('public/logos/seeding');
		$logo = $logos[array_rand($logos)];

		return [
			'name' => fake()->name(),
			'email' => fake()->unique()->safeEmail(),
			'logo' => basename($logo),
			'address' => fake()->address(),
		];
	}

}
