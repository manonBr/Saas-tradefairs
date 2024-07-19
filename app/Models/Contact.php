<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'gender',
        'lastname',
        'firstname',
        'company',
        'function',
        'mobile',
        'email',
        'phone',
        'adress',
        'zipcode',
        'city',
        'country',
        'notes',
        'csvToken',
        'siret',
        'tva',
        'newContact',
        'collaborator',
        'famille',
        'adressBis'
    ];
}
