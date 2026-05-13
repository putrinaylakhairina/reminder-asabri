<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reminder extends Model
{
    use HasFactory;

    protected $fillable = [
        'pensioner_id',
        'type',
        'title',
        'description',
        'remind_at',
        'sent_at',
        'status',
        'metadata',
    ];

    protected $casts = [
        'remind_at' => 'datetime',
        'sent_at' => 'datetime',
        'metadata' => 'array',
    ];

    public function pensioner(): BelongsTo
    {
        return $this->belongsTo(Pensioner::class);
    }

    /**
     * Scope a query to only include pending reminders.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include reminders due to be sent.
     */
    public function scopeDue($query)
    {
        return $query->where('status', 'pending')
                     ->where('remind_at', '<=', now());
    }
}
