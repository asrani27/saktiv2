<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatMessage extends Model
{
#[Fillable(['conversation_id', 'user_id', 'role', 'content', 'file_path', 'file_name', 'file_type', 'file_size'])]
protected $fillable = ['conversation_id', 'user_id', 'role', 'content', 'file_path', 'file_name', 'file_type', 'file_size'];

    /**
     * Get the conversation that owns the message.
     */
    public function conversation(): BelongsTo
    {
        return $this->belongsTo(ChatConversation::class, 'conversation_id');
    }

    /**
     * Get the user that owns the message.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}