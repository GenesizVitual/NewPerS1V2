<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailRegistrationPelatihan extends Mailable
{
    use Queueable, SerializesModels;
    public $posts;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($post1)
    {
        //
        $this->posts= $post1;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "Anda Telah Terdaftar Dalam Pelatihan Aplikasi Persediaan";
        return $this->subject($subject)->view('email.success_registrasi_pelatihan');
    }
}
