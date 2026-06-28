<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct()
    {
        //
    }

    public function build()
    {
        return $this->subject('Test Email - Website SMTP')
                    ->html('
                        <div style="font-family: Arial, sans-serif; line-height: 1.7; color: #1f2937;">
                            <h2 style="color:#004D80; margin-bottom: 12px;">Test Email Successful</h2>
                            <p>This is a test email sent from your Laravel website.</p>
                            <p>Your Gmail SMTP configuration is working correctly.</p>
                        </div>
                    ');
    }
}