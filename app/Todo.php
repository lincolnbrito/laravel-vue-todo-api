<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $fillable = ['title', 'completed','user_id'];
    protected $hidden = ['created_at', 'updated_at'];


    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
