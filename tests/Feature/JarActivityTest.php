<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class JarActivityTest extends TestCase
{
    /**
     * test if user can register activity
     * @return void
     */
    public function test_can_user_register_activity()
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
                    ->json('POST','api/activities',[
                        'content' => 'test activity',
                        'tags' => [
                            'music',
                            'coding'
                        ]
                    ]);

        $response->assertStatus(201)
                    ->assertJson(fn (AssertableJson $json) => 
                        $json->where('content','test_activity')
                            ->where('tags',['music','coding'])
                            ->where('user_id',$user->id)
                            ->etc()
                    );
    }

    public function test_can_user_list_activities(){
        $user = User::factory()->create();
        $activities = Activity::factory()->count(3)->create(['user_id'=>$user->id]);

        $response = $this->actingAs($user)->json('GET','api/activities');

        $response->assertStatus(200)
                    ->assertJsonCount(3)
                    ->assertJsonFragment(['user_id'=>$user->id]);
    }

    /**
     * test if user can edit an activity
     * @return void
     */
    public function test_can_user_edit_activity()
    {
        $user = User::factory()->create();
        $
    }

    /**
     * test if user can delete an activity
     * @return void
     */
    public function test_can_user_delete_activity(){

    }
}
