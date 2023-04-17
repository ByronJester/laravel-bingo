<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $with = [
        "cards"
    ];

    public function cards()
    {
        return $this->hasMany(Card::class);
    }

    public function getRolledNumbersAttribute($value)
    {
        $value = json_decode($value);

        return (array) $value;
    }
}
