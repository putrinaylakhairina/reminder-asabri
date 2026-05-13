<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Schedule;

Schedule::command('app:send-reminder')->daily();
