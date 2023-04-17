<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    public function getBAttribute($value)
    {
        return json_decode($value);
    }

    public function getIAttribute($value)
    {
        return json_decode($value);
    }

    public function getNAttribute($value)
    {
        return json_decode($value);
    }

    public function getGAttribute($value)
    {
        return json_decode($value);
    }

    public function getOAttribute($value)
    {
        return json_decode($value);
    }
}
