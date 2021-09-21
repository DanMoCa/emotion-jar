<?php

namespace Tests\Feature;

use App\Models\Jar;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;


class JarApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the user can create a Jar through the API
     * @return void
     */

    public function test_api_can_create_jar()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->json('POST','/api/jar',[
            'name' => 'test_jar'
        ]);        
        
        $response->assertStatus(201)
                ->assertJson(fn (AssertableJson $json) =>
                    $json->where('name','test_jar')
                        ->where('user_id',$user->id)
                        ->etc()
            );
    }

    /**
     * Test that the user can retrieve a jar by ID through the API
     * @return void
     */

    public function test_api_can_list_jar()
    {
        $user = User::factory()->create();
        $jar = Jar::factory()->create(['name'=>'listed_jar','user_id'=>$user->id]);

        $response = $this->actingAs($user)->json('GET','/api/jar/'.$jar->id);

        $response->assertStatus(200)
                ->assertJson(fn (AssertableJson $json) =>
                    $json->where('name','listed_jar')
                        ->where('user_id',$user->id)
                        ->etc()
            );
    }

    /**
     * Test that the user can update a jar through the API
     * @return void
     */

    public function test_api_can_update_jar()
    {
        $user = User::factory()->create();
        $jar = Jar::factory()->create(['user_id'=>$user->id]);

        $response = $this->actingAs($user)->json('PUT','/api/jar/'.$jar->id,[
            'name' => 'modified_jar'
        ]);

        $response->assertStatus(200)
                ->assertJson(fn (AssertableJson $json) =>
                    $json->where('name','modified_jar')
                        ->etc()
            );
    }

    /**
     * Test that the user can delete a jar through the API
     * @return void
     */
    public function test_api_can_delete_jar()
    {
        $user = User::factory()->create();
        $jar = Jar::factory()->create(['user_id'=>$user->id]);

        $response = $this->actingAs($user)->json('DELETE','/api/jar/'.$jar->id);

        $response->assertStatus(200)
                ->assertJson(fn (AssertableJson $json) =>
                    $json->where('message','Jar deleted successfully.')
                            ->etc()
            );
    }

    /**
     * Test that the user cannot retrieve another user's jar
     * @return void
     */

    public function test_api_cannot_retrieve_another_users_jar(){
        $user = User::factory()->create();
        $user2 = User::factory()->create();
        $jar = Jar::factory()->create(['user_id'=>$user->id]);

        $response = $this->actingAs($user2)->json('GET','/api/jar/'.$jar->id);

        $response->assertStatus(401)
                ->assertJsonFragment(['message'=>'unauthorized.']);
    }

    /**
     * Test that the user cannot update another user's jar
     * @return void
     */

    public function test_api_cannot_update_another_users_jar(){
        $user = User::factory()->create();
        $user2 = User::factory()->create();
        $jar = Jar::factory()->create(['user_id'=>$user->id]);

        $response = $this->actingAs($user2)->json('PUT','/api/jar/'.$jar->id,['name'=>'thief_jar']);

        $response->assertStatus(401)
                ->assertJsonFragment(['message'=>'unauthorized.']);
    }

    /**
     * Test that the user cannot delete another user's jar
     * @return void
     */

    public function test_api_cannot_delete_another_users_jar()
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();
        $jar = Jar::factory()->create(['user_id'=>$user->id]);

        $response = $this->actingAs($user2)->json('DELETE','/api/jar/'.$jar->id);

        $response->assertStatus(401)
                ->assertJsonFragment(['message'=>'unauthorized.']);
    }
}
