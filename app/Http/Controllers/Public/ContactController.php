<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Models\{ContactMessage, Setting};
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(string $locale)
    {
        return view('public.contacts', compact('locale'));
    }

    public function store(ContactRequest $request, string $locale)
    {
        ContactMessage::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'subject'    => $request->subject,
            'message'    => $request->message,
            'locale'     => $locale,
            'ip_address' => $request->ip(),
            'status'     => 'new',
        ]);

        $successMsg = match ($locale) {
            'kz'    => 'Хабарламаңыз жіберілді! Жақын арада сізбен байланысамыз.',
            'en'    => 'Your message has been sent! We will contact you soon.',
            default => 'Ваше сообщение отправлено! Мы свяжемся с вами в ближайшее время.',
        };

        return back()->with('success', $successMsg);
    }
}
