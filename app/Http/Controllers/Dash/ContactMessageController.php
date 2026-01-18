<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Services\ContactMessageService;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    protected $service;

    public function __construct(ContactMessageService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $messages = $this->service->paginate();
        return view('dash.contact_messages.index', compact('messages'));
    }

    public function show($id)
    {
        $message = $this->service->find($id);
        $this->service->markAsRead($message);
        return view('dash.contact_messages.show', compact('message'));
    }

    public function destroy($id)
    {
        $message = $this->service->find($id);
        $this->service->delete($message);
        return redirect()->route('contact-messages.index')->with('success', 'Message deleted successfully.');
    }
}
