<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Subscription;
use App\Models\Post;

class Topic extends Model
{
    use HasFactory;

    protected $table = 'topics';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'topics',
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
