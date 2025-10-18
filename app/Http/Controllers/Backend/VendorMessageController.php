<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorMessageController extends Controller
{
    /**
     ** عرض صفحة الرسائل للبائع
     ** Display the messages page for the vendor
     * @return View
     */
    function index(): View
    {
        $userId = Auth::user()->id;

        $chatUsers = Chat::with('senderProfile')->select(['sender_id'])
            ->where('receiver_id', $userId)
            ->where('sender_id', '!=', $userId)
            ->groupBy('sender_id')
            ->get();

        return view('vendor.messenger.index', compact('chatUsers'));
    }

    /**
     ** جلب الرسائل بين البائع ومستخدم آخر
     ** Get messages between the vendor and another user
     * @param Request $request
     * @return Response
     */
    function getMessages(Request $request)
    {
        $senderId = Auth::user()->id;
        $receiverId = $request->receiver_id;

        $messages = Chat::whereIn('receiver_id', [$senderId, $receiverId])
            ->whereIn('sender_id', [$senderId, $receiverId])
            ->orderBy('created_at', 'asc')
            ->get();
        Chat::where(['sender_id' => $receiverId, 'receiver_id' => $senderId])->update(['seen' => 1]);

        return response($messages);
    }

    /**
     ** إرسال رسالة إلى مستخدم آخر
     ** Send a message to another user
     * @param Request $request
     * @return Response
     */
    function sendMessage(Request $request)
    {
        $request->validate([
            'message' => ['required'],
            'receiver_id' => ['required']
        ]);

        $message = new Chat();
        $message->sender_id = Auth::user()->id;
        $message->receiver_id = $request->receiver_id;
        $message->message = $request->message;
        $message->save();

        // broadcast(new MessageEvent($message->message, $message->receiver_id, $message->created_at));

        return response(['status' => 'success', 'message' => 'message sent successfully']);
    }
}
