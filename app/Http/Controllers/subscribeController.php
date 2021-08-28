<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class subscribeController extends Controller
{
    //

    public function topic(Request $request, $topic)
    {
        if(!isset($topic))
        {
            return response()->json(['message'=>'Kindly please a topic via URL: /topic'],400);
        }


        $validator = Validator::make($request->all(),[
            "url"=>"required|string",
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(),400);
        }

        return response()->json(['url'=>$request->url, 'topic'=>$topic],200);

    }
}
