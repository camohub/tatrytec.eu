<?php

namespace App\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class Test extends Mailable
{
	use Queueable, SerializesModels;


	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		// $user as public prop. is automatically available in view.
		return $this->view('emails.test');
	}
}
