<?php
use Illuminate\Support\Facades\Schedule;
use App\Services\ReminderService;
Schedule::call(fn()=>app(ReminderService::class)->sendDue())->hourly();
