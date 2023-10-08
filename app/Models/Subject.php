<?php

namespace App\Models;

use App\Models\Unit;
use App\Models\Classe;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'class_id'
    ];

    public function classes()
    {
        return $this->belongsTo(Classe::class);
    }

    public function units()
    {
        return $this->hasMany(Unit::class);
    }
}