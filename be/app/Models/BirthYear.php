<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BirthYear extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
    ];

    protected $primarykey = 'id';

    public $incrementing = true;

    public function profiles()
    {
        return $this->hasMany(User::class, 'birth_year', 'id');
    }
}
