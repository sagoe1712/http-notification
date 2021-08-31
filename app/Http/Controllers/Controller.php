<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Topic;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function check_topic($topic){

        $count = Topic::where('topics', $topic)->count();

        return $count;

    }

    protected function return_topic_id($topic){

        $result = Topic::where('topics', $topic)->first();

        return $result->id;
    }


}
