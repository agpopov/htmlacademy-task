<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Str;
use Image;
use Tests\TestCase;

class WidgetControllerTest extends TestCase
{
    private User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->active()->hasReviews($this->faker->numberBetween(1, 100))->create();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_simple_ok()
    {
        $response = $this->get(route('widget', ['user' => $this->user->id]));
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'image/png');

        $widget = Image::make($response->content());
        $this->assertEquals('image/png', $widget->mime());
    }

    public function test_image_default_sizes()
    {
        $response = $this->get(route('widget', ['user' => $this->user->id]));

        $response->assertStatus(200);
        $widget = Image::make($response->content());

        $this->assertEquals(100, $widget->width());
        $this->assertEquals(100, $widget->height());
    }

    public function test_image_custom_sizes()
    {
        $width = $this->faker->numberBetween(100, 500);
        $height = $this->faker->numberBetween(100, 500);
        $response = $this->get(route('widget', ['user' => $this->user->id, 'width' => $width, 'height' => $height]));

        $response->assertStatus(200);
        $widget = Image::make($response->content());

        $this->assertEquals($width, $widget->width());
        $this->assertEquals($height, $widget->height());
    }

    public function test_image_default_background_color()
    {
        $response = $this->get(route('widget', ['user' => $this->user->id]));

        $response->assertStatus(200);
        $widget = Image::make($response->content());

        $this->assertEquals('#000000', $widget->pickColor(1, 1, 'hex'));
    }

    public function test_image_custom_background_color()
    {
        $color = $this->faker->hexColor;
        $response = $this->get(route('widget', ['user' => $this->user->id, 'background_color' => Str::substr($color, 1)]));

        $response->assertStatus(200);
        $widget = Image::make($response->content());

        $this->assertEquals($color, $widget->pickColor(1, 1, 'hex'));
    }

    public function test_image_default_text_color()
    {
        $response = $this->get(route('widget', ['user' => $this->user->id, 'width' => 500, 'height' => 500]));

        $response->assertStatus(200);
        $widget = Image::make($response->content());

        $colors = [];
        for ($x = 100; $x < 400; $x++) {
            $colors[] = $widget->pickColor($x, 250, 'hex');
        }

        $this->assertContains('#ffffff', $colors);
    }

    public function test_image_custom_text_color()
    {
        $color = $this->faker->hexColor;
        $response = $this->get(route('widget', ['user' => $this->user->id, 'text_color' => Str::substr($color, 1), 'width' => 500, 'height' => 500]));

        $response->assertStatus(200);
        $widget = Image::make($response->content());

        $colors = [];
        for ($x = 100; $x < 400; $x++) {
            $colors[] = $widget->pickColor($x, 250, 'hex');
        }

        $this->assertContains($color, $colors);
    }

    public function test_not_found_fake_user()
    {
        $response = $this->get(route('widget', ['user' => $this->faker->uuid]));
        $response->assertStatus(404);
    }

    public function test_not_found_inactive_user()
    {
        $user = User::factory()->inactive()->create();
        $response = $this->get(route('widget', ['user' => $user->id]));
        $response->assertStatus(404);
    }

}
