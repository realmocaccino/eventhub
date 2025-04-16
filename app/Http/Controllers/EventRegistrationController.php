<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Services\EventRegistrationService;
use Exception;

class EventRegistrationController extends Controller
{
    public function __construct(
        protected EventRegistrationService $registrationService
    ) {}

    public function register(Event $event)
    {
        try {
            $this->registrationService->register($event, auth()->user());

            return back()->with('success', __('You have registered for the event.'));
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function unregister(Event $event)
    {
        $this->registrationService->unregister($event, auth()->user());

        return back()->with('success', __('You have unregistered from the event.'));
    }
}