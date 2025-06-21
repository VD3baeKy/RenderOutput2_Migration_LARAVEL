<?php
  namespace app\http\Controllers;

  use Illuminate\Http\Request;
  use Illuminate\Http\Response;
  use app\Services\StripeService;
  use Stripe\Webhook;
  use Stripe\Stripe;
  use Stripe\Exception\SignatureVerificationException;

  class StripeWebhookController extends Controller{
    protected $stripeService;
    protected $stripeApiKey;
    protected $webhookSecret;

    public function __construct(StripeService $stripeService){
        $this->stripeService = $stripeService;
        $this->stripeApiKey = config('services.stripe.secret'); // 例: config/services.php
        $this->webhookSecret = env('STRIPE_WEBHOOK_SECRET');
    }

    public function webhook(Request $request){
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');

        Stripe::setApiKey($this->stripeApiKey);

        try {
            $event = Webhook::constructEvent(
                $payload, $sigHeader, $this->webhookSecret
            );
        } catch (SignatureVerificationException $e) {
            return response()->json(null, Response::HTTP_BAD_REQUEST);
        }

        if ($event->type === 'checkout.session.completed') {
            $this->stripeService->processSessionCompleted($event);
        }

        return response('Success', Response::HTTP_OK);
    }
}
