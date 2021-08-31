<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;

class publishController extends Controller
{
    //

private function get_subscription($topic)
{

    $result = Subscription::where('topic_id', $topic)->get();

    return $result;

}

    public function publish(Request $request, $topic)
    {
         //check topic
         $check_topic = $this->check_topic($topic);



        if($request->all() === null)
        {
            return response()->json(['data'=>[], 'topic'=>$topic],200);
        }

        return response()->json(['data'=>$request->all(), 'topic'=>$topic],200);

    }
}
