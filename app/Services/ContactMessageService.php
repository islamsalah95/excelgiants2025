<?php

namespace App\Services;

use App\Models\ContactMessage;

class ContactMessageService
{
    public function paginate($perPage = 10)
    {
        return ContactMessage::latest()->paginate($perPage);
    }

    public function find($id)
    {
        return ContactMessage::findOrFail($id);
    }

    public function store(array $data)
    {
        return ContactMessage::create($data);
    }

    public function markAsRead(ContactMessage $message)
    {
        $message->update(['is_read' => true]);
        return $message;
    }

    public function delete(ContactMessage $message)
    {
        return $message->delete();
    }
}
