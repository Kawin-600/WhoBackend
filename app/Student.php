<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{

    protected $fillable = [
        'user_id', 'first_name', 'last_name', 'address', 'tel', 'birth_date', 'department'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
