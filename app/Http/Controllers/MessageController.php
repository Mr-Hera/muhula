<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\School;
use App\Models\Message;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\ConversationParticipant;

class MessageController extends Controller
{
    public function messageList(Request $request){
        
        $schools = School::all();
        $messages = Message::with('sender')->get();
        $conversations = Conversation::whereHas('participants', function ($q) {
            $q->where('user_id', auth()->id());
        })->with('participants')->get();

        return view('dashboard.message_list')->with([
            'schools' => $schools,
            'messages' => $messages,
            'conversations' => $conversations,
        ]);
    }

    public function messageDetail($message_id=null){

        // Load the requested message with its sender + conversation
        $message = Message::with(['sender', 'conversation'])->find($message_id);

        if (!$message) {
            return redirect()->route('user.message.list');
        }

        // Fetch all messages in the same conversation, eager load senders
        $allMessages = Message::with('sender')
            ->where('conversation_id', $message->conversation_id)
            ->orderBy('created_at', 'asc')
            ->get();
        // dd($allMessages);

        // Optionally fetch participants of this conversation (if needed in blade)
        $participants = $message->conversation
            ? $message->conversation->participants()->get()
            : collect();

        return view('dashboard.message_Details')->with([
            'message'      => $message,
            'allMessages'  => $allMessages,
            'participants' => $participants,
        ]);
    }


    public function sendMessage(Request $request){
        // dd($request);
        $request->validate([
            'school_id' => 'required|integer|exists:schools,id',
            'message' => 'required|string',
            'attached_message_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $sender = User::where('id', Auth::id())->first();
        $school_contact = School::with('contact')
            ->find($request->school_id)
            ->contact;
        $receiver = User::where('id', $school_contact->id)->first();
        // dd($receiver);

        try {
            // Create a conversation
            $conversation = Conversation::create([
                'title' => $sender->name . ' & ' . $receiver->name . ' Chat',
            ]);

            // Add both as participants
            ConversationParticipant::create([
                'conversation_id' => $conversation->id,
                'user_id' => $sender->id,
                'joined_at' => now(),
            ]);

            ConversationParticipant::create([
                'conversation_id' => $conversation->id,
                'user_id' => $receiver->id,
                'joined_at' => now(),
            ]);

            // Track message being sent
            $message = Message::create([
                'conversation_id' => $conversation->id,
                'sender_id' => $sender->id,
                'content' => $request->message,
                'sent_at' => now(),
            ]);

            // Mail::send(new MessageMailToUser(@$mailData));

            // return success response
            return redirect()->back()->with('success', 'Message sent successfully!');
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Message sending failed: ' . $e->getMessage());

            // Redirect back with error message
            return redirect()->back()->with('error', 'Something went wrong while sending message.');
        }
    }
}
