<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## PROBLEMA 4

## Webhook de Stripe

    Implementa un endpoint para recibir y procesar eventos de Stripe. El sistema
    debe:
    1. Validar el evento recibido.
    2. Registrar los eventos invoice.payment_succeeded en la base de datos, guardando:
        ID del evento.
        Monto pagado.
        Fecha del evento.

### Paso 1. Instalamos Stripe y generamos en el .env tanto STRIPE_SECRET como STRIPE_WEBHOOK_SECRET

- composer require stripe/stripe-php

- STRIPE_SECRET= tu_clave_secreta_de_stripe # clave secreta de la API de Stripe
- STRIPE_WEBHOOK_SECRET= tu_secreto_del_webhook  # verificar la firma del webhook

STRIPE_SECRET:
Este es el secreto de la API de Stripe. Se utiliza para autenticar las solicitudes que tu aplicación hace a la API de Stripe. Permite a tu aplicación realizar operaciones como crear cargos, gestionar suscripciones, etc.

STRIPE_WEBHOOK_SECRET:
Este es el secreto del webhook de Stripe. Se utiliza para verificar la autenticidad de los eventos que Stripe envía a tu endpoint de webhook. Ayuda a asegurar que los eventos recibidos en tu webhook provienen realmente de Stripe y no de una fuente maliciosa.

### Paso 2. Creamos una migracion para los eventos de StripeEvent y editamos el archivo con los campos solicitados

    php artisan make:migration create_stripe_events_table --create=stripe_events

    public function up()
    {
    Schema::create('stripe_events', function (Blueprint $table) {
    $table->id();
    $table->string('event_id')->unique();
    $table->integer('amount_paid');
    $table->timestamp('event_date');
    $table->timestamps();
    });
    }

    php artisan migrate

### Paso 3. Se gestiona el modelo de StripeEvent y se edita el mismo para tener congruencia con los campos de la migration

    php artisan make:model StripeEvent

    //EN EL ARCHIVO MODEL
    protected $fillable = [
        'event_id',
        'amount_paid',
        'event_date',
    ];

 
### Paso 4. Se genera el controlador para el weebhook y se edita el mismo para parametrisar correctamente el manejo de eventos de STRIPE

    php artisan make:controller StripeWebhookController

    public function handleWebhook(Request $request)
        {
            try {
                // 1. Obtener la carga útil del evento
                $payload = $request->getContent();
                $sigHeader = $request->header('Stripe-Signature');
                $secret = env('STRIPE_WEBHOOK_SECRET');

                // 2. Verificar la firma del webhook (opcional pero recomendado)
                \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                $event = \Stripe\Webhook::constructEvent($payload, $sigHeader, $secret);

                // 3. Procesar el evento
                if ($event->type === 'invoice.payment_succeeded') {
                    $data = $event->data->object;

                    // Guardar los datos relevantes en la base de datos
                    StripeEvent::create([
                        'event_id' => $event->id,
                        'amount_paid' => $data->amount_paid,
                        'event_date' => now(),
                    ]);
                }

                return response('Webhook Handled', 200);
            } catch (\Exception $e) {
                // Registrar el error en los logs
                Log::error('Stripe Webhook Error: ' . $e->getMessage());
                return response('Webhook Error', 400);
            }
        }


### Paso 5. Defino las rutas en el api.php, registrando el api y luego creando la ruta en el archivo generado

    php artisan install:api

    Route::post('/webhook/stripe', [StripeWebhookController::class, 'handleWebhook']);

    //Verificamos las rutas registradas
    php artisan route:list

        GET|HEAD   / .............................................................................................................  
        GET|HEAD   api/user ......................................................................................................  
        POST       api/webhook/stripe ...................................................... StripeWebhookController@handleWebhook  
        GET|HEAD   sanctum/csrf-cookie ......................... sanctum.csrf-cookie › Laravel\Sanctum › CsrfCookieController@show  
        GET|HEAD   storage/{path} .................................................................................. storage.local  
        GET|HEAD   up ............................................................................................................ 

### Paso 6. Se configura el endpoint de Stripe

- El webhook es una URL en tu aplicación que Stripe utiliza para enviar notificaciones sobre eventos (como pagos realizados con éxito). Este paso consiste en registrar el endpoint en el sistema de Stripe.

- Dentro de Stripe se inicia cuenta como desarrollador
- Se agrega un endpoint dentro de  Webhooks configurando el dominio del servicio (API EN POST)

    https://tu-dominio/api/webhook/stripe

- Se selecciona los eventos invoice.payment_succeeded para qeu Stripe considere notificaciones bajo este evento en especial (pagos exitosos)
- Se guarda la configuracion
- Se obtiene la firma del webhook y se la guarda en el .env

### Paso 7. Uso del CLI de stripe

- Con la cuenta de Stripe logeamos en el Stripe CLI que existe en linea (stripe login)
- Se simula un evento webhook

    stripe trigger invoice.payment_succeeded

- Stripe enviará un payload a tu webhook registrado (local o en producción). Puedes observar la respuesta en tu terminal o en tus logs de Laravel.
- Para mejorar este paso se puede personalizar los registros de eventos en el log

    Log::info('Evento de Stripe recibido: ' . $event->type);// REGISTRO PERSONALIZADO DE EVENTOS EN EL LOG
    Log::info('Monto pagado: ' . $data->amount_paid); // REGISTRO PERSONALIZADO DE MONTO PAGADO EN EL LOG

