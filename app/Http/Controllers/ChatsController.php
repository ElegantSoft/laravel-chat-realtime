<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

class ChatsController extends Controller
{
   public function __construct()
   {
        $this->middleware('auth');
   }
   public function index(){
       return view('chats');
   }
   public function fetchAll()
   {
       return Message::with('user')->get();
   }

   public function sendMessage(Request $request)
   {
      $message = Auth::user()->messages()->create([
           'message' => $request->message,
          'room_id' => 5
       ]);
       broadcast(new MessageSent($message->load('user')))->toOthers();
       return ['status'=>'success'];
   }
}
