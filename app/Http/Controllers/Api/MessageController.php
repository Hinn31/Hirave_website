<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller; // ✅ cần import

use App\Models\Contact;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    // Hiển thị danh sách tất cả messages
   public function index(Request $request)
{
    $query = Contact::query();

    if ($request->has('search')) {
        $search = $request->input('search');
        $query->where('first_name', 'like', "%{$search}%")
              ->orWhere('last_name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
    }

    $messages = $query->orderBy('created_at', 'desc')->get();

    return view('pages.messages_managements', compact('messages'));
}


    // Xóa message
   public function destroy($id)
{
    $message = Contact::findOrFail($id);
    $message->delete();

    return redirect()->route('messages.index')
                     ->with('success', 'Message deleted successfully.');
}

}
