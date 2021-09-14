<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content'];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($instance) {
            $instance->created_by = request()->user()->id;
        });
    }
}
