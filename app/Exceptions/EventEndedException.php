<?php

namespace App\Exceptions;

use Exception;

class EventEndedException extends Exception
{
    public function __construct()
    {
        parent::__construct(__('Registration is closed for past events.'));
    }
}