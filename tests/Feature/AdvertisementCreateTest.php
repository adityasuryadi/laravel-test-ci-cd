<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use App\Models\User;

class AdvertisementCreateTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_not_access_index_without_authenticated(): void
    {
        $response = $this->get('/advertisement');
        $response->assertRedirect('login');
    }

    public function test_user_can_not_access_create_advertisment_page_without_authenticated()
    {
        $response = $this->get('/advertisement/create');
        $response->assertRedirect('login');
    }

    public function test_authenticated_user_can_visit_create_advertisement(): void
    {
        $user = User::factory()->create();
        $response = $this
        ->actingAs($user)
        ->get('advertisement/create')
        ->assertStatus(200);
    }

    public function test_create_advertisement_with_empty_name(): void
    {
        $user = User::factory()->create();
        $response = $this
        ->actingAs($user)
        ->post('advertisement', [
            'name'=>'',
            'duration'=>10,
            'link'=>'https://antrique.com',
            'image'=>UploadedFile::fake()->image('avatar.jpeg', 200, 200),
            'merchants'=>[1,2]
        ]);
        $response
        ->assertSessionHasErrors(['name'=>'The name field is required.'])
        ->assertStatus(302);
    }

    public function test_create_advertisement_with_empty_duration(): void
    {
        $user = User::factory()->create();
        $response = $this
        ->actingAs($user)
        ->post('advertisement', [
            'name'=>'iklan 1',
            'duration'=>null,
            'link'=>'https://antrique.com',
            'image'=>UploadedFile::fake()->image('avatar.png'),
            'merchants'=>[1,2]
        ]);
        $response
        ->assertSessionHasErrors(['duration'=>'The duration field is required.'])
        ->assertStatus(302);
    }

    public function test_create_advertisement_with_duration_string_input(): void
    {
        $user = User::factory()->create();
        $response = $this
        ->actingAs($user)
        ->post('advertisement', [
            'name'=>'iklan 1',
            'duration'=>'null',
            'link'=>'https://antrique.com',
            'image'=>UploadedFile::fake()->image('avatar.png'),
            'merchants'=>[1,2]
        ]);
        $response
        ->assertSessionHasErrors(['duration'=>'The duration must be a number.'])
        ->assertStatus(302);
    }

    public function test_create_advertisement_with_duration_lower_than_one_input(): void
    {
        $user = User::factory()->create();
        $response = $this
        ->actingAs($user)
        ->post('advertisement', [
            'name'=>'iklan 1',
            'duration'=>0,
            'link'=>'https://antrique.com',
            'image'=>UploadedFile::fake()->image('avatar.png'),
            'merchants'=>[1,2]
        ]);
        $response
        ->assertSessionHasErrors(['duration'=>'The duration must be at least 1.'])
        ->assertStatus(302);
    }

    public function test_create_advertisement_with_empty_link(): void
    {
        $user = User::factory()->create();
        $response = $this
        ->actingAs($user)
        ->post('advertisement', [
            'name'=>'iklan1',
            'duration'=>10,
            'link'=>'',
            'image'=>UploadedFile::fake()->image('avatar.png'),
            'merchants'=>[1,2]
        ]);
        $response
        ->assertSessionHasErrors(['link'=>'The link field is required.'])
        ->assertStatus(302);
    }

    public function test_create_advertisement_with_empty_image(): void
    {
        $user = User::factory()->create();
        $response = $this
        ->actingAs($user)
        ->post('advertisement', [
            'name'=>'iklan1',
            'duration'=>10,
            'link'=>'',
            'merchants'=>[1,2]
        ]);
        $response
        ->assertSessionHasErrors(['image'=>'The image field is required.'])
        ->assertStatus(302);
    }

    public function test_create_advertisement_with_invalid_image_file(): void
    {
        $user = User::factory()->create();
        $response = $this
        ->actingAs($user)
        ->post('advertisement', [
            'name'=>'iklan1',
            'duration'=>10,
            'link'=>'',
            'image'=>UploadedFile::fake()->create('avatar.pdf'),
            'merchants'=>[1,2]
        ]);
        $response
        ->assertSessionHasErrors(['image'=>'The image must be an image.'])
        ->assertStatus(302);
    }

    public function test_create_advertisement_with_merchant_empty(): void
    {
        $user = User::factory()->create();
        $response = $this
        ->actingAs($user)
        ->post('advertisement', [
            'name'=>'iklan1',
            'duration'=>10,
            'link'=>'http://antrique.com',
            'image'=>UploadedFile::fake()->image('avatar.png'),
            'merchants'=>[]
        ]);
        $response
        ->assertSessionHasErrors(['merchants'=>'The merchants field is required.'])
        ->assertStatus(302);
    }

    public function test_create_advertisement_success(): void
    {
        $user = User::factory()->create();
        $response = $this
        ->actingAs($user)
        ->post('advertisement', [
            'name'=>'iklan1',
            'duration'=>10,
            'link'=>'http://antrique.com',
            'image'=>UploadedFile::fake()->image('avatar.png'),
            'merchants'=>[30]
        ]);
        $response
        ->assertRedirect('/advertisement');
    }
}
