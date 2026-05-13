<?php

namespace Tests\Unit;

use App\Models\Pensioner;
use App\Models\Reminder;
use App\Models\User;
use App\Services\ReminderService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class ReminderServiceTest extends TestCase
{
    use RefreshDatabase;

    private ReminderService $reminderService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->reminderService = app(ReminderService::class);
    }

    public function test_can_create_reminder(): void
    {
        $user = User::factory()->create();
        $pensioner = Pensioner::create([
            'user_id' => $user->id,
            'nama' => 'John Doe',
            'nip' => '12345678',
            'instansi' => 'Polres',
            'gaji_pensiun' => 5000000,
            'tanggal_jatuh_tempo' => now()->addDays(10),
            'no_hp' => '08123456789',
            'email' => 'john@example.com',
        ]);

        $reminder = $this->reminderService->createReminder(
            $pensioner,
            'authentication',
            'Test Title',
            'Test Description',
            now()->addDay()
        );

        $this->assertInstanceOf(Reminder::class, $reminder);
        $this->assertEquals('Test Title', $reminder->title);
        $this->assertEquals('pending', $reminder->status);
    }

    public function test_auto_generate_reminders(): void
    {
        $user = User::factory()->create();
        
        // Pensioner approaching due date (5 days away)
        Pensioner::create([
            'user_id' => $user->id,
            'nama' => 'Approaching',
            'nip' => '88888888',
            'instansi' => 'Polres',
            'gaji_pensiun' => 5000000,
            'tanggal_jatuh_tempo' => now()->addDays(5),
            'no_hp' => '08123456789',
            'email' => 'john@example.com',
        ]);

        // Pensioner far from due date (20 days away)
        Pensioner::create([
            'user_id' => $user->id,
            'nama' => 'Far',
            'nip' => '99999999',
            'instansi' => 'Polres',
            'gaji_pensiun' => 5000000,
            'tanggal_jatuh_tempo' => now()->addDays(20),
            'no_hp' => '08123456789',
            'email' => 'jane@example.com',
        ]);

        $count = $this->reminderService->autoGenerateReminders();

        $this->assertEquals(1, $count);
        $this->assertDatabaseHas('reminders', [
            'title' => 'Otentikasi Tahunan Diperlukan',
        ]);
    }
}
