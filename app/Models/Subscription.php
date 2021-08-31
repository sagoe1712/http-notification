<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Topic;
use App\Models\Subscriber;

class Subscription extends Model
{
    use HasFactory;

    protected $table = 'subscriptions';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'subscriber_id',
        'topic_id',
    ];

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }


    public function subscriber()
    {
        return $this->belongsTo(Subscriber::class);
    }

}
