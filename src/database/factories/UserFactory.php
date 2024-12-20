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
        $imageContent = $this->downloadImage($imageUrl);

        if ($imageContent !== false) {

            $imageName = 'images/' . uniqid() . '.' . $this->getImageExtension($imageContent);
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
     * @param string $url
     * @return string|false
     */
    private function downloadImage(string $url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $imageContent = curl_exec($ch);

        if (curl_errno($ch)) {
            curl_close($ch);
            return false;
        }

        if (strlen($imageContent) < 1000) {
            curl_close($ch);
            return false;
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_buffer($finfo, $imageContent);
        finfo_close($finfo);

        if ($mimeType == 'image/jpeg' || $mimeType == 'image/png') {
            return $imageContent;
        }

        return false;
    }

    /**
     *
     *
     * @param string $imageContent
     * @return string
     */
    private function getImageExtension(string $imageContent)
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_buffer($finfo, $imageContent);
        finfo_close($finfo);

        if ($mimeType == 'image/jpeg') {
            return 'jpg';
        } elseif ($mimeType == 'image/png') {
            return 'png';
        }

        return 'jpg';
    }
}
