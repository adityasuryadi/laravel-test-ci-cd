<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Advertisement extends Model
{
    use HasFactory;
    use HasUuids;
    protected $table = 'advertisements';
    protected $fillable = ['name','source_url','duration','is_active','last_display'];
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $appends = ['merchants'];
    public $incrementing = false;

    public function advertisementDisplay()
    {
        return $this->hasMany(AdvertisementDisplay::class);
    }

    public function advertisementDisplayDetail()
    {
        return $this->hasMany(AdvertisementDisplayDetail::class);
    }

    /**
    * Determine  merrchants display
    *
    * @return \Illuminate\Database\Eloquent\Casts\Attribute
    */
    public function getMerchantsAttribute()
    {
        $displays = $this->advertisementDisplay;
        $merchants = [];

        foreach ($displays as $key => $value) {
            array_push($merchants, $value->merchant_id);
        }

        return $merchants;
    }
}
