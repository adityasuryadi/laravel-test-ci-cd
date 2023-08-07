<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use App\Models\User;
use App\Models\Advertisement;
use App\Models\AdvertisementDisplay;

class AdvertisementEditTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_guest_user_can_not_visit_edit_advertisement(): void
    {
        $user = User::factory()->create();
        $advertisement = Advertisement::factory()->has(AdvertisementDisplay::factory()->count(2))->create();
        $response = $this->get('advertisement/'.$advertisement->id.'/edit');
        $response->assertRedirect('login');
    }

    public function test_authenticated_user_can_visit_edit_advertisement(): void
    {
        $user = User::factory()->create();
        $advertisement = Advertisement::factory()->has(AdvertisementDisplay::factory()->count(2))->create();
        $response = $this
        ->actingAs($user)
        ->get('advertisement/'.$advertisement->id.'/edit')
        ->assertStatus(200);
    }

    public function test_update_advertisement_success(): void
    {
        $user = User::factory()->create();
        $advertisement = Advertisement::factory()->has(AdvertisementDisplay::factory()->count(2))->create();
        $response = $this
        ->actingAs($user)
        ->put('advertisement/'.$advertisement->id, [
            'name'=>'iklan1',
            'duration'=>10,
            'link'=>'http://antrique.com',
            'image'=>UploadedFile::fake()->image('avatar.png'),
            'merchants'=>[30]
        ]);
        $response
        ->assertRedirect('/advertisement');
    }

    public function test_update_advertisement_with_empty_name(): void
    {
        $user = User::factory()->create();
        $advertisement = Advertisement::factory()->has(AdvertisementDisplay::factory()->count(2))->create();
        $response = $this
        ->actingAs($user)
        ->put('advertisement/'.$advertisement->id, [
            'name'=>'',
            'duration'=>10,
            'link'=>'http://antrique.com',
            'image'=>UploadedFile::fake()->image('avatar.png'),
            'merchants'=>[30]
        ]);
        $response
        ->assertSessionHasErrors(['name'=>'The name field is required.'])
        ->assertStatus(302);
    }

    public function test_update_advertisement_with_empty_duration(): void
    {
        $user = User::factory()->create();
        $advertisement = Advertisement::factory()->has(AdvertisementDisplay::factory()->count(2))->create();
        $response = $this
        ->actingAs($user)
        ->put('advertisement/'.$advertisement->id, [
            'name'=>'name 1',
            'duration'=>'',
            'link'=>'http://antrique.com',
            'image'=>UploadedFile::fake()->image('avatar.png'),
            'merchants'=>[30]
        ]);
        $response
        ->assertSessionHasErrors(['duration'=>'The duration field is required.'])
        ->assertStatus(302);
    }

    public function test_update_advertisement_with_duration_input_string(): void
    {
        $user = User::factory()->create();
        $advertisement = Advertisement::factory()->has(AdvertisementDisplay::factory()->count(2))->create();
        $response = $this
        ->actingAs($user)
        ->put('advertisement/'.$advertisement->id, [
            'name'=>'name 1',
            'duration'=>'test',
            'link'=>'http://antrique.com',
            'image'=>UploadedFile::fake()->image('avatar.png'),
            'merchants'=>[30]
        ]);
        $response
        ->assertSessionHasErrors(['duration'=>'The duration must be a number.'])
        ->assertStatus(302);
    }

    public function test_update_advertisement_with_duration_input_lower_than_one(): void
    {
        $user = User::factory()->create();
        $advertisement = Advertisement::factory()->has(AdvertisementDisplay::factory()->count(2))->create();
        $response = $this
        ->actingAs($user)
        ->put('advertisement/'.$advertisement->id, [
            'name'=>'name 1',
            'duration'=>0,
            'link'=>'http://antrique.com',
            'image'=>UploadedFile::fake()->image('avatar.png'),
            'merchants'=>[30]
        ]);
        $response
        ->assertSessionHasErrors(['duration'=>'The duration must be at least 1.'])
        ->assertStatus(302);
    }

    public function test_update_advertisement_with_empty_link(): void
    {
        $user = User::factory()->create();
        $advertisement = Advertisement::factory()->has(AdvertisementDisplay::factory()->count(2))->create();
        $response = $this
        ->actingAs($user)
        ->put('advertisement/'.$advertisement->id, [
            'name'=>'iklan 1',
            'duration'=>10,
            'link'=>'',
            'image'=>UploadedFile::fake()->image('avatar.png'),
            'merchants'=>[30]
        ]);
        $response
        ->assertSessionHasErrors(['link'=>'The link field is required.'])
        ->assertStatus(302);
    }

    public function test_update_advertisement_with_with_invalid_image_file(): void
    {
        // dd(UploadedFile::fake()->create('avatar.pdf', 100, 'pdf'));
        $user = User::factory()->create();
        $advertisement = Advertisement::factory()->has(AdvertisementDisplay::factory()->count(2))->create();
        $response = $this
        ->actingAs($user)
        ->put('advertisement/'.$advertisement->id, [
            'name'=>'iklan 1',
            'duration'=>10,
            'link'=>'https://antrique.com',
            'image'=>UploadedFile::fake()->create('avatar.pdf', 100, 'PDF'),
            'merchants'=>[30]
        ]);
        $response
        ->assertSessionHasErrors(['image'=>'The image must be an image.'])
        ->assertStatus(302);
    }

    public function test_update_advertisement_with_with_empty_mercahnt(): void
    {
        $user = User::factory()->create();
        $advertisement = Advertisement::factory()->has(AdvertisementDisplay::factory()->count(2))->create();
        $response = $this
        ->actingAs($user)
        ->put('advertisement/'.$advertisement->id, [
            'name'=>'iklan 1',
            'duration'=>10,
            'link'=>'https://antrique.com',
            'image'=>UploadedFile::fake()->create('avatar.pdf'),
            'merchants'=>[]
        ]);
        $response
        ->assertSessionHasErrors(['merchants'=>'The merchants field is required.'])
        ->assertStatus(302);
    }

}
