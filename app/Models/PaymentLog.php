<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentLog extends Model
{
    protected $fillable = [
        'pensioner_id',
        'tanggal',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function pensioner(): BelongsTo
    {
        return $this->belongsTo(Pensioner::class);
    }
}
