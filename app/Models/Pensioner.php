<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pensioner extends Model
{
    protected $fillable = [
        'user_id',
        'nama',
        'nip',
        'instansi',
        'gaji_pensiun',
        'tanggal_jatuh_tempo',
        'no_hp',
        'email',
    ];

    protected $casts = [
        'tanggal_jatuh_tempo' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function paymentLogs(): HasMany
    {
        return $this->hasMany(PaymentLog::class);
    }

    public function reminders(): HasMany
    {
        return $this->hasMany(Reminder::class);
    }

    public function getStatusAttribute(): string
    {
        $today = Carbon::today();
        $dueDate = Carbon::parse($this->tanggal_jatuh_tempo);

        if ($today->greaterThanOrEqualTo($dueDate)) {
            return 'jatuh_tempo';
        }

        $diffInDays = $today->diffInDays($dueDate, false);

        if ($diffInDays <= 3) {
            return 'mendekati';
        }

        return 'aman';
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'jatuh_tempo' => 'red',
            'mendekati' => 'yellow',
            'aman' => 'green',
            default => 'gray',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'jatuh_tempo' => 'Jatuh Tempo',
            'mendekati' => 'Mendekati',
            'aman' => 'Aman',
            default => 'Unknown',
        };
    }
}
