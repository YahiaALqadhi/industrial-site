<?php

namespace App\Mail;

use App\Models\Inquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewInquiryMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Inquiry $inquiry)
    {
    }

    public function build()
    {
        $subject = '[New Inquiry] ' . ucfirst($this->inquiry->type);

        if ($this->inquiry->subject) {
            $subject .= ' - ' . $this->inquiry->subject;
        } elseif ($this->inquiry->product) {
            $subject .= ' - ' . $this->inquiry->product->name;
        } else {
            $subject .= ' - #' . $this->inquiry->id;
        }

        $visitorName = $this->inquiry->name ?: $this->inquiry->email;

        return $this
            ->from(
                config('mail.from.address'),
                $visitorName
            )
            ->replyTo(
                $this->inquiry->email,
                $visitorName
            )
            ->subject($subject)
            ->view('emails.new_inquiry')
            ->with([
                'inquiry' => $this->inquiry,
            ]);
    }
}