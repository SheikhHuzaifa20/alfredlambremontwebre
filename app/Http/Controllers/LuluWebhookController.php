<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\OrderStatusLogs;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LuluWebhookController extends Controller
{
    /**
     * Handle incoming webhooks from Lulu Print API.
     */
    public function handleWebhook(Request $request): JsonResponse
    {
        $payload = $request->all();

        Log::info('LuluWebhook: Received payload', ['payload' => $payload]);

        if (empty($payload)) {
            return response()->json(['message' => 'Empty payload'], 400);
        }

        // Support both direct payload or nested data payload
        $data = $payload['data'] ?? $payload;

        $jobId = $data['id'] ?? $payload['id'] ?? null;
        $externalRef = $data['external_reference'] ?? $payload['external_reference'] ?? null;

        $order = null;

        if ($jobId) {
            $order = Orders::where('lulu_job_id', (string) $jobId)->first();
        }

        if (!$order && $externalRef) {
            $orderId = str_replace('ORD-', '', (string) $externalRef);
            $order = Orders::where('id', $orderId)->first();
        }

        if (!$order) {
            Log::warning('LuluWebhook: Matching order not found', [
                'job_id' => $jobId,
                'external_reference' => $externalRef,
            ]);

            return response()->json([
                'status' => 'ignored',
                'message' => 'Order not found for this notification',
            ], 200);
        }

        // Extract status
        $statusName = null;
        if (isset($data['status']['name'])) {
            $statusName = $data['status']['name'];
        } elseif (isset($data['status']) && is_string($data['status'])) {
            $statusName = $data['status'];
        }

        if ($statusName) {
            $order->lulu_status = $statusName;
        }

        // Extract Tracking Information
        $shipments = $data['shipments'] ?? ($payload['shipments'] ?? []);
        if (is_array($shipments)) {
            foreach ($shipments as $shipment) {
                if (!empty($shipment['tracking_number'])) {
                    $order->lulu_tracking_number = (string) $shipment['tracking_number'];
                }
                if (!empty($shipment['tracking_urls']) && is_array($shipment['tracking_urls'])) {
                    $order->lulu_tracking_url = (string) ($shipment['tracking_urls'][0] ?? '');
                }
            }
        }

        // Check if shipped
        if ($statusName && in_array(strtoupper($statusName), ['SHIPPED', 'DELIVERED'])) {
            $order->order_status = 'shipped';

            OrderStatusLogs::create([
                'order_id' => $order->id,
                'status'   => 'shipped',
            ]);
        }

        $order->save();

        Log::info("LuluWebhook: Successfully updated Order #{$order->id} to status {$order->lulu_status}");

        return response()->json([
            'status' => 'success',
            'order_id' => $order->id,
            'lulu_status' => $order->lulu_status,
        ], 200);
    }
}

