<?php

namespace App\Mail;


use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class ForgottenPassword extends Mailable
{
	use Queueable, SerializesModels;


	public $token = NULL;


	public function __construct($token)
	{
		$this->token = $token;
	}


	public function build()
	{
		// $token as public prop. is automatically available in view.
		return $this->view('emails.forgotten-password');
	}
}
