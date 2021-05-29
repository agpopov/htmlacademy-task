<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class WidgetRequestValidationTest extends TestCase
{
    private User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->active()->create();
    }

    public function test_width_validation_errors()
    {
        $width = $this->faker->numberBetween(501);
        $response = $this->get(route('widget', ['user' => $this->user->id, 'width' => $width]));
        $response->assertStatus(422);

        $width = $this->faker->numberBetween(0, 99);
        $response = $this->get(route('widget', ['user' => $this->user->id, 'width' => $width]));
        $response->assertStatus(422);

        $width = $this->faker->name;
        $response = $this->get(route('widget', ['user' => $this->user->id, 'width' => $width]));
        $response->assertStatus(422);
    }

    public function test_height_validation_errors()
    {
        $height = $this->faker->numberBetween(501);
        $response = $this->get(route('widget', ['user' => $this->user->id, 'height' => $height]));
        $response->assertStatus(422);

        $height = $this->faker->numberBetween(0, 99);
        $response = $this->get(route('widget', ['user' => $this->user->id, 'height' => $height]));
        $response->assertStatus(422);

        $height = $this->faker->name;
        $response = $this->get(route('widget', ['user' => $this->user->id, 'height' => $height]));
        $response->assertStatus(422);
    }

    public function test_background_color_validation_errors()
    {
        $color = $this->faker->boolean;
        $response = $this->get(route('widget', ['user' => $this->user->id, 'background_color' => $color]));
        $response->assertStatus(422);

        $color = $this->faker->numberBetween(1000000);
        $response = $this->get(route('widget', ['user' => $this->user->id, 'background_color' => $color]));
        $response->assertStatus(422);

        /* parameter must be without # symbol */
        $color = $this->faker->hexColor;
        $response = $this->get(route('widget', ['user' => $this->user->id, 'background_color' => $color]));
        $response->assertStatus(422);
    }

    public function test_text_color_validation_errors()
    {
        $color = $this->faker->boolean;
        $response = $this->get(route('widget', ['user' => $this->user->id, 'text_color' => $color]));
        $response->assertStatus(422);

        $color = $this->faker->numberBetween(1000000);
        $response = $this->get(route('widget', ['user' => $this->user->id, 'text_color' => $color]));
        $response->assertStatus(422);

        /* parameter must be without # symbol */
        $color = $this->faker->hexColor;
        $response = $this->get(route('widget', ['user' => $this->user->id, 'text_color' => $color]));
        $response->assertStatus(422);
    }
}
