<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvertisementDisplayDetail extends Model
{
    use HasFactory;
    protected $fillable=['merchant_id','payload'];
    protected $table='advertisement_display_details';
}
