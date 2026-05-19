<?php

declare(strict_types=1);

namespace App\Services;

use App\Mail\ReminderPensiun;
use App\Models\PaymentLog;
use App\Models\Reminder;
use App\Models\Pensioner;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ReminderService
{
    public function __construct() {}

    /**
     * Create a reminder for a pensioner.
     */
    public function createReminder(Pensioner $pensioner, string $type, string $title, string $description, Carbon $remindAt): Reminder
    {
        return $pensioner->reminders()->create([
            'type' => $type,
            'title' => $title,
            'description' => $description,
            'remind_at' => $remindAt,
            'status' => 'pending',
        ]);
    }

    /**
     * Get all pending reminders that are due to be sent.
     */
    public function getDueReminders(): Collection
    {
        return Reminder::due()->with('pensioner')->get();
    }

    /**
     * Mark a reminder as sent.
     */
    public function markAsSent(Reminder $reminder): void
    {
        $reminder->update([
            'status' => 'sent',
            'sent_at' => now(),
        ]);
    }

    /**
     * Send a reminder via Email, then mark as sent.
     */
    public function sendReminder(Reminder $reminder): array
    {
        $pensioner = $reminder->pensioner;
        $results = ['email' => false, 'errors' => []];

        // 1. Send Email
        try {
            Mail::to($pensioner->email)->send(new ReminderPensiun($pensioner));
            PaymentLog::create([
                'pensioner_id' => $pensioner->id,
                'tanggal' => Carbon::now(),
                'status' => 'email_sent',
            ]);
            $results['email'] = true;
        } catch (\Exception $e) {
            Log::error("Failed to send email to {$pensioner->email}: " . $e->getMessage());
            $results['errors'][] = 'Email gagal dikirim: ' . $e->getMessage();
        }

        // 2. Update reminder status
        if ($results['email']) {
            $this->markAsSent($reminder);
        } else {
            $reminder->update(['status' => 'failed']);
        }

        return $results;
    }

    /**
     * Automatically generate reminders for pensioners whose due date is approaching.
     */
    public function autoGenerateReminders(): int
    {
        $count = 0;
        $upcomingPensioners = Pensioner::where('tanggal_jatuh_tempo', '<=', now()->addDays(7))
            ->where('tanggal_jatuh_tempo', '>=', now())
            ->get();

        foreach ($upcomingPensioners as $pensioner) {
            // Check if reminder already exists for this cycle
            $exists = $pensioner->reminders()
                ->where('type', 'authentication')
                ->where('status', 'pending')
                ->exists();

            if (!$exists) {
                $this->createReminder(
                    $pensioner,
                    'authentication',
                    'Otentikasi Tahunan Diperlukan',
                    'Segera lakukan otentikasi tahunan sebelum tanggal ' . $pensioner->tanggal_jatuh_tempo->format('d/m/Y'),
                    now() // Remind now
                );
                $count++;
            }
        }

        return $count;
    }

    /**
     * Search reminders with filters (paginated).
     */
    public function searchReminders(?string $status = null, ?string $search = null, int $perPage = 15): LengthAwarePaginator
    {
        $query = Reminder::with('pensioner');

        if ($status) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->whereHas('pensioner', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%");
            });
        }

        return $query->latest()->paginate($perPage)->withQueryString();
    }
}
