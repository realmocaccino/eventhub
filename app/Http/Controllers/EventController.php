<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterSortRequest;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use App\Services\EventRegistrationService;
use App\Services\EventService;
use Inertia\Inertia;

class EventController extends Controller
{
    public function __construct(
        protected EventService $eventService,
        protected EventRegistrationService $eventRegistrationService
    ) {}

    public function index(FilterSortRequest $request)
    {
        $events = $this->eventService->getAllEvents(
            $filters = $request->only(['start_date', 'end_date']),
            $request->sort,
            $request->direction
        );

        return Inertia::render('Events/Index', [
            'events' => $events,
            'filters' => $filters
        ]);
    }

    public function create()
    {
        return Inertia::render('Events/Create');
    }

    public function store(StoreEventRequest $request)
    {
        $this->eventService->createEvent(
            $request->validated(),
            $request->file('image')
        );

        return redirect()->route('events.index')->with('success', __('Event created.'));
    }

    public function show(Event $event)
    {
        $user = auth()->user();

        return Inertia::render('Events/Show', [
            'event' => $this->eventService->getEventWithUsers($event->id),
            'registered' => $user ? $this->eventRegistrationService->isUserRegistered(
                $event,
                $user
            ) : false,
        ]);
    }

    public function edit(Event $event)
    {
        return Inertia::render('Events/Edit', [
            'event' => $event,
        ]);
    }

    public function update(UpdateEventRequest $request, Event $event)
    {
        $this->eventService->updateEvent(
            $event->id,
            $request->validated(),
            $request->file('image')
        );

        return redirect()->route('events.index')->with('success', __('Event updated.'));
    }

    public function destroy(Event $event)
    {
        $this->eventService->deleteEvent($event->id);
        
        return redirect()->route('events.index')->with('success', __('Event deleted.'));
    }

    public function manage(FilterSortRequest $request)
    {
        $events = $this->eventService->getAllEvents(
            $filters = $request->only(['start_date', 'end_date']),
            $request->sort,
            $request->direction
        );

        return Inertia::render('Events/Manage', [
            'events' => $events,
            'filters' => $filters
        ]);
    }
}
