<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvertisementDisplay extends Model
{
    use HasFactory;
    protected $table = "advertisement_displays";
    protected $fillable=["merchant_id"];
}
