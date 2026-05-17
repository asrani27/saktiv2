<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChatConversation extends Model
{
    #[Fillable(['user_id', 'title'])]
    protected $fillable = ['user_id', 'title'];

    /**
     * Get the user that owns the conversation.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all messages in the conversation.
     */
    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class, 'conversation_id')->orderBy('created_at', 'asc');
    }

    /**
     * Get the last message in the conversation.
     */
    public function lastMessage(): HasMany
    {
        return $this->hasMany(ChatMessage::class, 'conversation_id')->latest()->limit(1);
    }
}