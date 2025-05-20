<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;


class organizer implements ShouldQueue
{
    use Queueable;

    public function __construct(public $user)
    {

    }

    public function handle(): void
    {
        $tasks = DB::table('tasks')->where('user', $this->user)
            ->orderby('priority', "desc")->get();

        $user = DB::table('users')->where('id', $this->user)->first();

        $dailyMinutes = $user->minutes;
        $daysToPlan = $user->week ? 7 : 5;
        $startDate = Carbon::now()->startOfDay();

        $calendar = $this->generateCalendar($startDate, $dailyMinutes, $daysToPlan);
        foreach ($tasks as $task) {
            $slot = $this->findSlot($calendar, $task->duration);

            if ($slot) {
                DB::table('tasks')->where('id', $task->id)->update([
                    'scheduled_at' => $slot,
                    'updated_at' => now()
                ]);

                $calendar = $this->blockTime($calendar, $slot, $task->duration);
            }
        }
        GeneratePDFJob::dispatch($calendar)->onqueue('tasks');
        Redis::setex("schedule:{$this->user}", 86400, json_encode($calendar));

    }
    private function generateCalendar(Carbon $startDate, int $dailyMinutes, int $days): array
    {
        $calendar = [];

        for ($i = 0; $i < $days; $i++) {
            $date = $startDate->copy()->addDays($i);

            if (!$this->userWantsWeekend() && $date->isWeekend()) {
                continue;
            }

            $calendar[$date->format('Y-m-d') . ' 08:00'] = $dailyMinutes;
        }

        return $calendar;
    }
    private function findSlot(array $calendar, int $duration): ?string
    {
        foreach ($calendar as $startTime => $availableMinutes) {
            if ($availableMinutes >= $duration) {
                return $startTime;
            }
        }

        return null;
    }
    private function blockTime(array $calendar, string $startTime, int $duration): array
    {
        if (!isset($calendar[$startTime])) {
            return $calendar;
        }

        $remaining = $calendar[$startTime] - $duration;

        if ($remaining <= 0) {
            unset($calendar[$startTime]);
        } else {
            $nextStart = Carbon::parse($startTime)->addMinutes($duration)->format('Y-m-d H:i');
            unset($calendar[$startTime]);
            $calendar[$nextStart] = $remaining;
        }

        return $calendar;
    }
    private function userWantsWeekend(): bool
    {
        $user = DB::table('users')->where('id', $this->user)->first();
        return $user->week ?? false;
    }

}
