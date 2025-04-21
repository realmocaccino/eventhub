<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Services\EventRegistrationService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Tag(
 *     name="Event Registration",
 *     description="API endpoints for event registration management"
 * )
 */
class EventRegistrationController extends Controller
{
    public function __construct(protected EventRegistrationService $service) {}

    /**
     * Register for an event
     *
     * @OA\Post(
     *     path="/api/events/{event}/register",
     *     tags={"Event Registration"},
     *     summary="Register for an event",
     *     operationId="registerForEvent",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="event",
     *         in="path",
     *         required=true,
     *         description="Event ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully registered",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Registered to event")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Event not found"
     *     ),
     *     )
     * )
     */
    public function register(Event $event): JsonResponse
    {
        $this->service->register($event, auth()->user());

        return response()->json([
            'message' => __('Registered to event')
        ], Response::HTTP_OK);
    }

    /**
     * Unregister from an event
     *
     * @OA\Delete(
     *     path="/api/events/{event}/unregister",
     *     tags={"Event Registration"},
     *     summary="Unregister from an event",
     *     operationId="unregisterFromEvent",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="event",
     *         in="path",
     *         required=true,
     *         description="Event ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully unregistered",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unregistered from event")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Event not found or not registered"
     *     )
     * )
     */
    public function unregister(Event $event): JsonResponse
    {
        $this->service->unregister($event, auth()->user());

        return response()->json([
            'message' => __('Unregistered from event')
        ], Response::HTTP_OK);
    }
}
