<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_can_create()
    {
        $user = User::factory()->create();
        $this->assertDatabaseHas('users', ['id' => $user->id]);
    }

    public function test_can_update()
    {
        $user = User::factory()->create();

        $user->name = $name = $this->faker->name;
        $user->save();

        $this->assertDatabaseHas('users', ['id' => $user->id, 'name' => $name]);
    }

    public function test_can_delete()
    {
        $user = User::factory()->create();

        $user->delete();
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_can_get_reviews()
    {
        $user = User::factory()->hasReviews($number = $this->faker->numberBetween(1, 100))->create();
        $this->assertCount($number, $user->reviews);
    }

    public function test_active_scope()
    {
        User::factory()->create(['status' => ($active = $this->faker->boolean) ? User::STATUS_ACTIVE : User::STATUS_INACTIVE]);

        $this->assertCount($active ? 1 : 0, User::active()->get());
    }

    public function test_can_get_average_score()
    {
        $user = User::factory()->hasReviews($this->faker->numberBetween(1, 100))->create();
        $this->assertEquals($user->reviews()->published()->pluck('score')->avg(), $user->getAvgScore());
    }
}
