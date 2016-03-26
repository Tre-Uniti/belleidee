<?php

namespace App\Http\Controllers;

use Laravel\Cashier\WebhookController as BaseController;

class WebhookController extends BaseController
{
    /**
     * Handle a stripe webhook.
     *
     * @param  array  $payload
     * @return Response
     */
    public function handleInvoicePaymentSucceeded($payload)
    {
        // Handle The Event
    }
}