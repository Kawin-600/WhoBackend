<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{

    protected $table = 'educations';
    protected $fillable = [
        'user_id',
        'primary_school',
        'middle_school',
        'high_school',
        'university'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
