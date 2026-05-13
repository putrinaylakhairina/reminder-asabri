<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Pensioner;
use App\Models\Reminder;
use App\Services\ReminderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Carbon\Carbon;

class ReminderController extends Controller
{
    public function __construct(
        private readonly ReminderService $reminderService
    ) {}

    /**
     * Display a listing of reminders.
     */
    public function index(Request $request): View
    {
        $status = $request->query('status');
        $search = $request->query('search');

        $reminders = $this->reminderService->searchReminders(
            $status ? (string) $status : null,
            $search ? (string) $search : null
        );

        // Get counts for stats
        $totalCount = Reminder::count();
        $pendingCount = Reminder::where('status', 'pending')->count();
        $sentCount = Reminder::where('status', 'sent')->count();

        return view('reminders.index', [
            'reminders' => $reminders,
            'currentStatus' => $status,
            'search' => $search,
            'totalCount' => $totalCount,
            'pendingCount' => $pendingCount,
            'sentCount' => $sentCount,
        ]);
    }

    /**
     * Show the form for creating a new reminder.
     */
    public function create(): View
    {
        $pensioners = Pensioner::orderBy('nama')->get();

        return view('reminders.create', compact('pensioners'));
    }

    /**
     * Store a newly created reminder.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'pensioner_id' => 'required|exists:pensioners,id',
            'type' => 'required|in:authentication,payment,renewal',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'remind_at' => 'required|date',
        ]);

        $pensioner = Pensioner::findOrFail($validated['pensioner_id']);

        $this->reminderService->createReminder(
            $pensioner,
            $validated['type'],
            $validated['title'],
            $validated['description'] ?? '',
            Carbon::parse($validated['remind_at'])
        );

        return redirect()->route('admin.reminders.index')
            ->with('success', 'Reminder berhasil dibuat.');
    }

    /**
     * Send a reminder (email + WhatsApp) and mark as sent.
     */
    public function send(Reminder $reminder): RedirectResponse
    {
        if ($reminder->status !== 'pending') {
            return back()->with('error', 'Hanya reminder dengan status pending yang bisa dikirim.');
        }

        $results = $this->reminderService->sendReminder($reminder);

        if ($results['email'] || $results['whatsapp']) {
            $channels = [];
            if ($results['email']) $channels[] = 'Email';
            if ($results['whatsapp']) $channels[] = 'WhatsApp';

            return back()->with('success', 'Reminder berhasil dikirim via ' . implode(' & ', $channels) . '.');
        }

        return back()->with('error', 'Gagal mengirim reminder. ' . implode(', ', $results['errors']));
    }

    /**
     * Trigger auto-generation of reminders.
     */
    public function generate(): RedirectResponse
    {
        $count = $this->reminderService->autoGenerateReminders();

        return redirect()->route('admin.reminders.index')
            ->with('success', "{$count} reminder baru telah dibuat.");
    }

    /**
     * Remove the specified reminder.
     */
    public function destroy(Reminder $reminder): RedirectResponse
    {
        $reminder->delete();

        return back()->with('success', 'Reminder berhasil dihapus.');
    }
}
