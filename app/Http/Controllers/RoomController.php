<?php

namespace App\Http\Controllers;

use App\Events\MessageRoomSent;
use App\Message;
use App\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    public function index($id)
    {
        $room = Room::find($id)->load('messages.user','owner','lancer');
        $messages= $room->messages()->paginate(10);
        $lastPage = $messages->lastPage();
        if(Auth::user()->id !== $room->owner_id && Auth::user()->id !== $room->lancer_id){
            abort(404);
        }
        return view('room',compact('room','messages','lastPage'));
    }
    public function sendMessage(Request $request)
    {
//        $room = Room::find($request->id);
//        $room->messages()->create([
//            'message' => $request->message,
//            'user_id' => $request->user,
//        ]);
        $message = Message::create([
            'message' => $request->message,
            'user_id' => $request->user,
            'room_id' => $request->id,
        ]);
        broadcast(new MessageRoomSent($message->load('user')))->toOthers();
        return ['status'=>'success'];
    }
    public function getRoomMessages(Request $request,$id)
    {
        $room = Room::find($id);
        $messages = $room->messages()->with('user')->paginate(10);
        return $messages;
    }
}
