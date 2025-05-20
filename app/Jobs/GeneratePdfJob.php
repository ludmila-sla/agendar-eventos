<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redis;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use App\Mail\ScheduleMail;

class GeneratePdfJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    public function __construct($userId)
    {
        $this->user = $userId;
    }

    public function handle(): void
    {
        $data = Redis::get("schedule:{$this->user}");

        if (!$data) {
            throw new \Exception("Nenhum cronograma encontrado no Redis.");
        }

        $schedule = json_decode($data, true);

        $pdf = Pdf::loadView('schedule.pdf', ['schedule' => $schedule]);

        $path = "schedules/{$this->user}_schedule.pdf";
        Storage::put($path, $pdf->output());

        $email = DB::table('users')->where('id', $this->user)->value('email');
        if ($email) {
            Mail::to($email)->send(new ScheduleMail($path));
        }
    }
}
