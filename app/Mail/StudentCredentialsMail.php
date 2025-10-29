<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class StudentCredentialsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $student;
    public $username;
    public $password;
    public $loginUrl;

    /**
     * Create a new message instance.
     */
    public function __construct($student, $username, $password)
    {
        $this->student = $student;
        $this->username = $username;
        $this->password = $password;
        $this->loginUrl = config('app.url') . '/login';
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('Welcome to MCA Montessori - Your Login Credentials')
            ->view('emails.student_credentials')
            ->with([
                'studentName' => ($this->student->first_name ?? '') . ' ' . ($this->student->last_name ?? ''),
                'username' => $this->username,
                'password' => $this->password,
                'loginUrl' => $this->loginUrl,
            ]);
    }
}
