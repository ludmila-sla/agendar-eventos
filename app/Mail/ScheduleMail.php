<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ScheduleMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function build()
    {
        return $this->subject('Seu cronograma está pronto!')
                    ->view('emails.schedule')
                    ->attach(storage_path("app/{$this->path}"));
    }
}

