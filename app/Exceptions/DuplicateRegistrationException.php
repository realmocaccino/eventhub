<?php

namespace App\Exceptions;

use Exception;

class DuplicateRegistrationException extends Exception
{
    public function __construct()
    {
        parent::__construct(__('You are already registered for this event.'));
    }
}