<?php

namespace App\Console\Commands;

use App\Services\ReminderService;
use Illuminate\Console\Command;

class SendReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-reminder';

    /**
     * The description of the console command.
     *
     * @var string
     */
    protected $description = 'Automate pension payment reminders via records in the reminders table';

    /**
     * Execute the console command.
     */
    public function handle(ReminderService $reminderService)
    {
        $this->info('Starting automated reminder process...');

        // 1. Generate reminders for upcoming due dates (if not already exists)
        $this->info('Generating upcoming reminders...');
        $generatedCount = $reminderService->autoGenerateReminders();
        $this->info("{$generatedCount} new reminders generated.");

        // 2. Fetch all pending reminders that are due to be sent
        $this->info('Fetching due reminders...');
        $dueReminders = $reminderService->getDueReminders();
        $dueCount = $dueReminders->count();
        $this->info("Found {$dueCount} reminders due to be sent.");

        if ($dueCount === 0) {
            $this->info('No reminders to send today.');
            return;
        }

        $sentCount = 0;
        $failedCount = 0;

        foreach ($dueReminders as $reminder) {
            $this->info("Sending reminder ID: {$reminder->id} to {$reminder->pensioner->nama}...");
            
            $results = $reminderService->sendReminder($reminder);

            if ($results['email']) {
                $sentCount++;
                $this->info("Successfully sent reminder ID: {$reminder->id}");
            } else {
                $failedCount++;
                $this->error("Failed to send reminder ID: {$reminder->id}");
                foreach ($results['errors'] as $error) {
                    $this->error(" - {$error}");
                }
            }
        }

        $this->info("Process finished. Total Sent: {$sentCount}, Total Failed: {$failedCount}");
    }
}
