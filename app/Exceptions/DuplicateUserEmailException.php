<?php

namespace App\Exceptions;


use Exception;

class DuplicateUserEmailException extends \Exception
{

	// This is only to show $user data in error message
	public $user;


	public function __construct( $user )
	{
		$this->user = $user;
	}
}