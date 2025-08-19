<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Conversation;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function messageList(Request $request){
        
        $messages = Message::with('sender')->get();
        $conversations = Conversation::whereHas('participants', function ($q) {
            $q->where('user_id', auth()->id());
        })->with('participants')->get();

        return view('dashboard.message_list')->with([
            'messages' => $messages,
            'conversations' => $conversations,
        ]);
     }

     public function messageDetail($message_id=null){

           $data['message'] = Message::where('id',@$message_id)->first();
           if($data['message'] == null){

                return redirect()->route('user.message.list');
           }
           $data['allMessage'] = Message::where('to_user_id',Auth::user()->id)->where('from_user_id',@$data['message']->from_user_id)
                                  ->orWhere('to_user_id',@$data['message']->from_user_id)->where('from_user_id',Auth::user()->id)->get();

           return view('modules.user.message.message_Details')->with($data);
     }


     public function sendMessage(Request $request){

          $ins = [];

          $ins['school_id'] = $request->school_id;
          $ins['from_user_id'] = Auth::user()->id;
          $ins['to_user_id'] = $request->to_user_id;
          $ins['message'] = $request->message;
          $ins['date'] = date('Y-m-d H:i:s');
          $ins['is_read'] = 'N';
          $ins['new_message'] = 'Y';

          $create = Message::create($ins);

          Message::where('id',@$request->message_id)->update(['is_read'=>'Y','new_message'=>'N']);

          $toUser = User::where('id',@$request->to_user_id)->first();
          $fromUser = User::where('id',Auth::user()->id)->first();

          $mailData = [];
          
           $mailData['to_user_name'] = @$toUser->first_name.' '.@$toUser->last_name;
           $mailData['to_user_email'] = @$toUser->email;
           $mailData['from_user_name'] = @$fromUser->first_name.' '.@$fromUser->last_name;
           $mailData['message'] = $request->message;
           $mailData['subject'] = "Message Mail";

           Mail::send(new MessageMailToUser(@$mailData));

          if(@$create){

              return redirect()->back()->with('success','Message send successfully');
          }else{

            return redirect()->back()->with('error','Something went wrong');
          }
     }
}
