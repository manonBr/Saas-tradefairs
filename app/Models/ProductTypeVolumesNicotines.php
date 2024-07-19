<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTypeVolumesNicotines extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $table = 'product_type_volumes_nicotines';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'productType_id',
        'volumes_id' ,
        'nicotines_id',
        'active'
    ];
  
}
