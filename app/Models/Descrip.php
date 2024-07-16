<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Descrip extends Model
{
    use HasFactory;

    protected $fillable = [
        'intereses', 
        'drescription',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
