<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\StripeEvent;

class StripeWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        try {
            // SE OBTIENE LA INFORMACION DEL WEBHOOK QUE CONTIENE LA FIRMA
            $payload = $request->getContent(); //OBTENGO EL PAYLOAD
            $sigHeader = $request->header('Stripe-Signature'); //OBTENGO LA FIRMA
            $secret = env('STRIPE_WEBHOOK_SECRET'); //GESTIONO GLOBAL CON LOS DATOS DE LA CUENTA DE STRIPE

            // VERIFICO LA FIRMA DEL WEBHOOK
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET')); //GESTIONO GLOBAL EN EL .ENV
            $event = \Stripe\Webhook::constructEvent($payload, $sigHeader, $secret); //VERIFICO LA FIRMA CON LA LLAVE SECRETA

            // PROCESO EL EVENTO DE LA TRANSACCION
            if ($event->type === 'invoice.payment_succeeded') {
                $data = $event->data->object; //OBTENGO LOS DATOS DEL EVENTO

                // SE GRABA EN LA BASE DE DATOS USANDO EL MODELO
                StripeEvent::create([
                    'event_id' => $event->id,
                    'amount_paid' => $data->amount_paid,
                    'event_date' => now(),
                ]);
            }
            Log::info('Evento de Stripe recibido: ' . $event->type);// REGISTRO PERSONALIZADO DE EVENTOS EN EL LOG
            Log::info('Monto pagado: ' . $data->amount_paid); // REGISTRO PERSONALIZADO DE MONTO PAGADO EN EL LOG
            // RESPONDO AL WEBHOOK
            return response('Webhook Handled', 200);
        } catch (\Exception $e) {
            // REGISTRO EL ERROR
            Log::error('Stripe Webhook Error: ' . $e->getMessage());
            return response('Webhook Error', 400);// RETORNO UN ERROR
        }
    }
}
