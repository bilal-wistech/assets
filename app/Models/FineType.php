<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FineType extends Model
{
    use HasFactory;

    protected $table = 'fine_types';

    public function fine()
    {
        return $this->hasMany(Fine::class , 'fine_type', 'id');
    }
}
