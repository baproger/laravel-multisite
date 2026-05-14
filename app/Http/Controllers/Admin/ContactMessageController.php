<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function index(Request $request)
    {
        $query = ContactMessage::latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $messages = $query->paginate(20);
        return view('admin.messages.index', compact('messages'));
    }

    public function show(int $id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->markAsRead();
        return view('admin.messages.show', compact('message'));
    }

    public function destroy(int $id)
    {
        ContactMessage::findOrFail($id)->delete();
        return back()->with('success', 'Сообщение удалено');
    }
}
