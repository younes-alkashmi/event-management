<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category_id',
        'date',
        'max_tickets',
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }
    
    public function tickets() {
        return $this->hasMany(Ticket::class);
    }
}
