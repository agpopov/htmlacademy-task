<?php


use App\Models\Review;
use App\Models\User;
use Tests\TestCase;

class ReviewTest extends TestCase
{
    public function test_can_create()
    {
        $review = Review::factory()->forUser()->create();
        $this->assertDatabaseHas('reviews', ['id' => $review->id]);
    }

    public function test_can_update()
    {
        $review = Review::factory()->forUser()->create();
        $review->score = $score = $this->faker->numberBetween(0, 100);
        $review->save();

        $this->assertDatabaseHas('reviews', ['id' => $review->id, 'score' => $score]);
    }

    public function test_can_delete()
    {
        $review = Review::factory()->forUser()->create();
        $review->delete();

        $this->assertDatabaseMissing('reviews', ['id' => $review->id]);
    }

    public function test_can_get_user()
    {
        $user = User::factory()->create();
        $review = Review::factory()->for($user)->create();

        $this->assertEquals($user->id, $review->user->id);
    }

    public function test_published_scope()
    {
        Review::factory()->forUser()->create(['published' => $published = $this->faker->boolean]);
        $this->assertCount($published ? 1 : 0, Review::published()->get());
    }
}
