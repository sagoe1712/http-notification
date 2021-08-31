<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Subscription;
use App\Models\Post;

class Subscriber extends Model
{
    use HasFactory;

    protected $table = 'subscribers';

     /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'url',
    ];

    public function subscription()
    {
        return $this->hasMany(Subscription::class);
    }

    public function post()
    {
        return $this->hasMany(Post::class);
    }

}
