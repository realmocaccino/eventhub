<?php

namespace App\Exceptions;

use Exception;

class EventFullException extends Exception
{
    public function __construct()
    {
        parent::__construct(__('This event has reached maximum capacity.'));
    }
}