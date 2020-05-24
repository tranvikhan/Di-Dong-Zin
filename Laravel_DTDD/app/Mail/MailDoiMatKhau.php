<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailDoiMatKhau extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $data;

    public function __construct($valArr)
    {
        $this->data = $valArr;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('tanthinh199915@gmail.com')
                        ->subject('DiDongZin gửi bạn mật khẩu mới')
                        ->view('user.Email_DoiMatKhau');
    }
}
