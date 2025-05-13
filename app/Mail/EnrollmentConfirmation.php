<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Models\NewStudentEnrollee;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class EnrollmentConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $enrollee;

    public function __construct(NewStudentEnrollee $enrollee)
    {
        $this->enrollee = $enrollee;
    }

    public function build()
    {
        return $this
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('Your MCA Montessori Enrollment Confirmation')
            ->view('new_enrollment_confirmation')
            ->with(['enrollee' => $this->enrollee]);
    }
}
