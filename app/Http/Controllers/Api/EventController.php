<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Services\EventService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Tag(
 *     name="Events",
 *     description="API endpoints for managing events"
 * )
 */
class EventController extends Controller
{
    public function __construct(
        protected EventService $eventService
    ) {}

    /**
     * Get all events
     * 
     * @OA\Get(
     *     path="/api/events",
     *     tags={"Events"},
     *     summary="Get all events",
     *     operationId="getEvents",
     *     @OA\Response(
     *         response=200,
     *         description="List of events",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/EventResource")),
     *             @OA\Property(property="message", type="string", example="Events retrieved successfully")
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        return EventResource::collection($this->eventService->getAllEvents())
            ->additional([
                'message' => __('Events retrieved successfully')
            ])
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Create a new event
     * 
     * @OA\Post(
     *     path="/api/events",
     *     tags={"Events"},
     *     summary="Create new event",
     *     operationId="createEvent",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreEventRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Event created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/EventResource"),
     *             @OA\Property(property="message", type="string", example="Event created")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(StoreEventRequest $request): JsonResponse
    {
        $event = $this->eventService->createEvent(
            $request->validated()
        );

        return (new EventResource($event))
            ->additional([
                'message' => __('Event created')
            ])
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Get specific event
     * 
     * @OA\Get(
     *     path="/api/events/{id}",
     *     tags={"Events"},
     *     summary="Get specific event",
     *     operationId="getEvent",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Event ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Event details",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/EventResource"),
     *             @OA\Property(property="message", type="string", example="Event retrieved successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Event not found"
     *     )
     * )
     */
    public function show(Event $event): JsonResponse
    {
        return (new EventResource($event))
            ->additional([
                'message' => __('Event retrieved successfully')
            ])
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Update event
     * 
     * @OA\Put(
     *     path="/api/events/{id}",
     *     tags={"Events"},
     *     summary="Update event",
     *     operationId="updateEvent",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Event ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateEventRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Event updated",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/EventResource"),
     *             @OA\Property(property="message", type="string", example="Event updated")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Event not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function update(UpdateEventRequest $request, Event $event): JsonResponse
    {
        $event = $this->eventService->updateEvent(
            $event->id,
            $request->validated()
        );

        return (new EventResource($event))
            ->additional([
                'message' => __('Event updated')
            ])
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Delete event
     * 
     * @OA\Delete(
     *     path="/api/events/{id}",
     *     tags={"Events"},
     *     summary="Delete event",
     *     operationId="deleteEvent",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Event ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Event deleted",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Event deleted")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Event not found"
     *     )
     * )
     */
    public function destroy(Event $event): JsonResponse
    {
        $this->eventService->deleteEvent($event->id);

        return response()
            ->json([
                'message' => __('Event deleted')
            ])
            ->setStatusCode(Response::HTTP_OK);
    }
}