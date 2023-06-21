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
    protected $fillable = ['name','source_url','duration'];
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
}
