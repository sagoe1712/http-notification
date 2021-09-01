<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Topic;
use App\Models\Subscriber;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    public $primaryKey ='id';
    
    protected $fillable = [
        'subscriber_id',
        'topic_id',
        'payload',
    ];

    // public function topic()
    // {
    //     return $this->belongsTo(Topic::class);
    // }


    public function subscriber()
    {
        return $this->belongsTo(Subscriber::class);
    }

}
