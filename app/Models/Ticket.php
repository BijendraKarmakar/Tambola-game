<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    
    protected $table = 'tickets-all';
    public $timestamps = true;
    
    protected $fillable = [
        't_parent_id',
        't_key',
        't_value'
    ];
}
