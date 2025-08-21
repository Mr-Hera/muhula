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
        })
        ->with(['messages' => function ($q) {
            $q->latest(); // ensure messages come sorted by latest first
        }, 'messages.sender', 'participants'])
        ->get();

        // Group conversations by title and keep only the one with the latest message
        $conversations = $conversations
            ->groupBy('title')
            ->map(function ($group) {
                return $group->sortByDesc(function ($conv) {
                    // get latest message date for each conversation
                    return optional($conv->messages->first())->created_at;
                })->first(); // pick latest by message date
            })
            ->values(); // reset keys to have a clean collection

        // Flatten messages from the reduced conversations
        $messages = $conversations->pluck('messages')->flatten();

        return view('dashboard.message_list')->with([
            'schools' => $schools,
            'messages' => $messages,
            'conversations' => $conversations,
        ]);
    }

    public function messageDetail($message_id=null){
        // 1. Find the message we came from (with its conversation)
        $message = Message::with('conversation')->find($message_id);

        if (!$message || !$message->conversation) {
            return redirect()->route('user.message.list');
        }

        // 2. Get the conversation title
        $conversationTitle = $message->conversation->title;

        // 3. Find all conversation IDs that share this title
        $conversationIds = Conversation::where('title', $conversationTitle)->pluck('id');

        // 4. Get all messages from those conversations, latest first, eager load senders
        $allMessages = Message::with('sender')
            ->whereIn('conversation_id', $conversationIds)
            ->orderBy('created_at', 'desc') // latest first
            ->get();

        // 5. Get all participants (from ALL these conversations if needed)
        $participants = Conversation::whereIn('id', $conversationIds)
            ->with('participants')
            ->get()
            ->pluck('participants')
            ->flatten()
            ->unique('id'); // remove duplicates

        return view('dashboard.message_Details')->with([
            'message'      => $message,       // original message
            'allMessages'  => $allMessages,   // all related messages
            'participants' => $participants,  // unique participants
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
        $school = School::where('school_contact_id', $school_contact->id)->first();
        // dd($school);
        $receiver = User::where('id', $school_contact->id)->first();
        // dd($receiver);

        try {
            // Create a conversation
            $conversation = Conversation::create([
                'title' => $school->name . ' Chat',
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

    public function replyMessage(Request $request){
        // dd($request);
        // Validate only what reply needs
        $request->validate([
            'message_id' => 'required|integer|exists:messages,id',
            'message' => 'required|string',
            'attached_message_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        try {
            // Get the original message being replied to
            $originalMessage = Message::findOrFail($request->message_id);

            // Fetch the conversation from that message
            $conversation = Conversation::findOrFail($originalMessage->conversation_id);

            // Get the current authenticated user
            $sender = User::findOrFail(Auth::id());

            // Ensure the sender is a participant in the conversation
            $alreadyParticipant = ConversationParticipant::where('conversation_id', $conversation->id)
                ->where('user_id', $sender->id)
                ->exists();

            if (!$alreadyParticipant) {
                ConversationParticipant::create([
                    'conversation_id' => $conversation->id,
                    'user_id' => $sender->id,
                    'joined_at' => now(),
                ]);
            }

            // Create the reply message
            $message = Message::create([
                'conversation_id' => $conversation->id,
                'sender_id' => $sender->id,
                'content' => $request->message,
                'reply_to_id' => $originalMessage->id, // track reply relationship
                'sent_at' => now(),
            ]);

            // If you want to store attachment
            if ($request->hasFile('attached_message_image')) {
                $path = $request->file('attached_message_image')->store('message_attachments', 'public');
                $message->attachment_path = $path;
                $message->save();
            }

            // Success response
            return redirect()->back()->with('success', 'Message sent successfully!');
        } catch (\Exception $e) {
            Log::error('Reply message failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong while replying to message.');
        }
    }
}
