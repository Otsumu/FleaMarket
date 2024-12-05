<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        $faker = \Faker\Factory::create('ja_JP');

        $imageUrl = $faker->imageUrl(400, 400, 'people');
        $imageContent = $this->getImageContent($imageUrl);

        if ($imageContent !== false) {
            $imageName = 'images/' . uniqid() . '.jpg';
            Storage::disk('public')->put($imageName, $imageContent);
        } else {
            $imageName = 'images/default.jpg';
        }

        return [
            'name' => $this->faker->lastName() . ' ' . $this->faker->firstName(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => bcrypt('password'),
            'address' => $this->faker->address(),
            'image' => $imageName,
        ];
    }

    /**
     *
     *
     * @param string $url
     * @return string|false
     */
    private function getImageContent(string $url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $imageContent = curl_exec($ch);

        if (curl_errno($ch)) {
            curl_close($ch);
            return false;
        }

        curl_close($ch);
        return $imageContent;
    }
}