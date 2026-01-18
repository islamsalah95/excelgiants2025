<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\ContactMessageService;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    protected $service;

    public function __construct(ContactMessageService $service)
    {
        $this->service = $service;
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $this->service->store($request->all());

        return back()->with('success', 'تم إرسال رسالتك بنجاح. سنقوم بالرد عليك في أقرب وقت.');
    }
}
