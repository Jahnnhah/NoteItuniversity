<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    // Specify the table name if it's different from the plural form of the model name
    protected $table = 'config';

    // Specify the primary key if it's not 'id'
    protected $primaryKey = 'id';

    // Set timestamps to false if your table doesn't have `created_at` and `updated_at` columns
    public $timestamps = false;
}
