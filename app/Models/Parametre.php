<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parametre extends Model
{
    use HasFactory;

    // Specify the table name if it's different from the default 'parametres'
    protected $table = 'parametre';

    // Specify the fillable fields to allow mass assignment
    protected $fillable = [
        'borneinf',
        'bornesup',
        'couleur',
    ];
    public $timestamps = false;
}

