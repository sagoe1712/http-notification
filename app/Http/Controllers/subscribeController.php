<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use App\Models\Subscription;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class subscribeController extends Controller
{
    //

 
    private function check_subscriber($url){

        $count = Subscriber::where('url', $url)->count();

        return $count;

    }

    private function store_subscriber($name){
        $subscriber = new Subscriber;
        $subscriber->url = $name;
        return $subscriber->save();
    }

    private function store_subscription($subscriber, $topic){
        $subscription = new Subscription;
        $subscription->subscriber_id = $subscriber;
        $subscription->topic_id = $topic;
        return $subscription->save();
    }

    private function check_subscription($subscriber, $topic){

        $count = Subscription::where('subscriber_id', $subscriber)->where('topic_id', $topic)->count();

        return $count;

    }

    private function return_subscriber_id($subscriber){

        $result = Subscriber::where('url', $subscriber)->first();

        return $result->id;
    }

    public function createSubscription(Request $request, $topic)
    {
        // if(!isset($topic))
        // {
        //     return response()->json(['message'=>'Kindly please a topic via URL: /topic'],400);
        // }

        $topic_id = "";
        $subscriber_id = "";

        // validating of body
        $validator = Validator::make($request->all(),[
            "url"=>"required|string",
        ]);
        if($validator->fails())
        {
            return response()->json($validator->errors(),400);
        }

        //check topic
        $check_topic = $this->check_topic($topic);

        // dd($check_topic);

        if($check_topic < 1)
        {

            $insert_topic = $this->store_topic($topic);

            if($insert_topic == false)
            {

                return response()->json(['message'=>'Inserting into topics table error'],400);

            }

            $topic_id = $this->return_topic_id($topic);

        }
        else
        {

            $topic_id = $this->return_topic_id($topic);

        }

      

       //check url/subscriber
       $check_url = $this->check_subscriber($request->url);

       if($check_url < 1)
       {
           //inserts url into the subscriber table
           $insert_subscriber = $this->store_subscriber($request->url);

           if($insert_subscriber == false)
           {

               return response()->json(['message'=>'Inserting into subscriber table error'],400);

           }
           else
           {
               $subscriber_id = $this->return_subscriber_id($request->url);
           }
       }
       else
       {
            $subscriber_id = $this->return_subscriber_id($request->url);
       }


       // crosscheck if topic id is set
       if(!isset($topic_id))
       {
        return response()->json(['message'=>'Unable to get topic id'],400);
       }

       // crosscheck if subscriber id is set
       if(!isset($subscriber_id))
       {
        return response()->json(['message'=>'Unable to get subscriber id'],400);
       }

       $check_subscription = $this->check_subscription($subscriber_id, $topic_id);

       if($check_subscription > 0)
       {
        return response()->json(['message'=>'Subscriber is already subscribed to the topic'],400);
       }
       else
       {
           $insert_subscription = $this->store_subscription($subscriber_id, $topic_id);

           if($insert_subscription == true)
           {
                return response()->json(['url'=>$request->url, 'topic'=>$topic],200);
           }
           else
           {
            return response()->json(['message'=>'Error creating subscription'],400);
           }
       }


        

    }

 
}
