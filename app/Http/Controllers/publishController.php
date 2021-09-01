<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class publishController extends Controller
{
    //

private function get_subscription($topic)
{

    $result = Subscription::where('topic_id', $topic)->with('subscriber',)->get();
    // $result = Subscription::find($topic);

    return $result;

}

private function store_post($subscriber_id = null, $subscriber_endpoint = null, $topic_id, $payload)
{

    $post = new Post;
    $post->subscriber_id = $subscriber_id;
    $post->subscriber_endpoint = $subscriber_endpoint;
    $post->topic_id = $topic_id;
    $post->payload = $payload;
    return $post->save();


}

    public function publish(Request $request, $topic)
    {
         //check topic
         $check_topic = $this->check_topic($topic);
         $topic_id = "";

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
         
// dd($topic_id);
           // crosscheck if topic id is set
       if(!isset($topic_id))
       {
        return response()->json(['message'=>'Unable to get topic id'],400);
       }


       if($this->check_topic_subscription($topic_id) > 0)
       {
            $fetch_subscriptions = $this->get_subscription($topic_id);

            // echo $fetch_subscriptions;
            //  echo $fetch_subscriptions[0]->subscriber->url;
            //  die;

            //loop the fetch data
            foreach ($fetch_subscriptions as $sub) 
            {
             
                $new_sub_id = $sub->subscriber_id;
                $new_sub_endpoint = "";
              
                $new_sub_endpoint = $sub->subscriber->url;
                
                $new_sub_topic = $sub->topic_id;
                $new_payload = json_encode($request->all());

                //Insert inside the post table representing publish to endpoint
                $publish = $this->store_post($new_sub_id, $new_sub_endpoint, $new_sub_topic, $new_payload);

                if($publish == false)
                {
                    echo "Did Not Publish to endpoint: ".$new_sub_endpoint;
                }
                else
                {
                    $str = [];
                    $str = ['data'=>$request->all(), 'topic'=>$topic];
                    // echo json_encode($str);
                }

            }

            $notify_subscribers = Subscription::where('topic_id', $topic_id)
            ->update(['notified'=>1]);

            if($notify_subscribers)
            {
                 if($request->all() === null)
                    {
                        return response()->json(['data'=>[], 'topic'=>$topic],200);
                    }
        
                return response()->json(['data'=>$request->all(), 'topic'=>$topic],200);
            }
            else
            {
                return response()->json(['message'=>'Could not notify subscribers'],400);
            }

       }
       else
       {
        $publish = $this->store_post(null, null, $topic_id, json_encode($request->all()));

        if($publish == true)
        {
            return response()->json(['data'=>$request->all(), 'topic'=>$topic],200);
        }
        else
        {
            return response()->json(['message'=>'Could not publish topic'],400);
        }
       }

        // if($request->all() === null)
        // {
        //     return response()->json(['data'=>[], 'topic'=>$topic],200);
        // }

    }
}
