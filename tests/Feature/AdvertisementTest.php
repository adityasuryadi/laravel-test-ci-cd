<?php

namespace Tests\Feature;

use App\Models\Advertisement;
use App\Models\AdvertisementDisplay;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdvertisementTest extends TestCase
{
    // use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_index_page_is_displayed(): void
    {
        $user = User::factory()->create();
        $response = $this
        ->actingAs($user)
        ->get('/advertisement');

        $response->assertStatus(200);
    }

    public function test_get_ads_by_merchant_id(): void
    {
        $advertisement = Advertisement::factory()
        // ->has(AdvertisementDisplay::factory())
        ->create();

        $display = AdvertisementDisplay::factory()->create(['advertisement_id'=>$advertisement->id,'merchant_id'=>30]);

        $response = $this->post('api/ads', [
            'merchant_id'=>30
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data'=>[
                "id",
                "name",
                "link",
                "source_url",
                "duration"
            ]
        ]);


    }

    // test untuk api get ads by merchantId
    public function test_get_advertisement_by_merchant_not_found()
    {
        $response = $this->post('/api/ads', ['merchant_id'=>10000]);
        $response->assertStatus(404);
        $response->assertNotFound();
    }

    // test merchant_id null
    public function test_get_advertisement_by_merchant_id_null()
    {
        $response = $this->post('/api/ads', ['merchant_id'=>""]);
        $response->assertStatus(400);
        $response->assertBadRequest();
        $response->assertSee('The merchant id field is required.');
    }

    public function test_get_advertisement_by_merchant_id_not_number()
    {
        $response = $this->post('/api/ads', ['merchant_id'=>"asw"]);
        $response->assertStatus(400);
        $response->assertBadRequest();
        $response->assertSee('The merchant id must be a number.');
    }

}
