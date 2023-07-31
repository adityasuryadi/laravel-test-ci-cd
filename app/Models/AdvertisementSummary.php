<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvertisementSummary extends Model
{
    use HasFactory;
    protected $table = 'advertisement_summaries';
    protected $primaryKey ='id';
    protected $fillable = ['advertisement_id','total_view','total_duration'];
}
