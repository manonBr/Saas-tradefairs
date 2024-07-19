<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $casts = [
        'active' => 'boolean',
    ];

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ranges_id',
        'name',
        'code_art',
        'volume',
        'volumes_id',
        'nicotine',
        'nicotines_id',
        'name_shorten',
        'specificPrice',
        'active',
        'productTypeVolumesNicotines_id'
    ];

}
