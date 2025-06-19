<?php

  namespace App\Http\Services;
  
  use Illuminate\Support\Facades\Log;
  use Illuminate\Support\Facades\Config;
  use Stripe\Stripe;
  use Stripe\Checkout\Session as StripeSession;
  use App\Http\Services\ReservationService;
  
  class StripeService{
      protected $reservationService;
  
      // .envまたはconfig/services.php からAPIキーを取得
      public function __construct(ReservationService $reservationService){
          $this->reservationService = $reservationService;
          Stripe::setApiKey(config('services.stripe.secret'));
      }
  
      // Stripeセッション作成
      public function createStripeSession(string $houseName, array $form, string $requestUrl): ?string {
          try {
              // リダイレクトURLの生成
              $successUrl = preg_replace('#/houses/\d+/reservations/confirm#', '', $requestUrl) . '/reservations?reserved';
              $cancelUrl = str_replace('/reservations/confirm', '', $requestUrl);
  
              // セッション作成
              $session = StripeSession::create([
                  'payment_method_types' => ['card'],
                  'line_items' => [[
                      'price_data' => [
                          'currency' => 'jpy',
                          'product_data' => [
                              'name' => $houseName,
                          ],
                          'unit_amount' => (int)$form['amount'],
                      ],
                      'quantity' => 1,
                  ]],
                  'mode' => 'payment',
                  'success_url' => $successUrl,
                  'cancel_url' => $cancelUrl,
                  'payment_intent_data' => [
                      'metadata' => [
                          'houseId' => $form['house_id'],
                          'userId' => $form['user_id'],
                          'checkinDate' => $form['checkin_date'],
                          'checkoutDate' => $form['checkout_date'],
                          'numberOfPeople' => $form['number_of_people'],
                          'amount' => $form['amount'],
                      ],
                  ],
              ]);
              return $session->id;
          } catch (\Exception $e) {
              Log::error('Stripe session作成失敗: ' . $e->getMessage());
              return null;
          }
      }
  
      // Webhookで呼ばれる
      public function processSessionCompleted($event){
          if (isset($event->data->object)) {
              $session = $event->data->object;
              try {
                  // payment_intentをexpandして取得
                  $stripeSession = StripeSession::retrieve([
                      'id' => $session->id,
                      'expand' => ['payment_intent'],
                  ]);
                  $metadata = $stripeSession->payment_intent->metadata ?? [];
                  $this->reservationService->create($metadata);
  
                  Log::info('予約一覧ページの登録処理が成功しました。');
              } catch (\Exception $e) {
                  Log::error('予約登録失敗: ' . $e->getMessage());
              }
          } else {
              Log::info('Stripe Eventデータ取得失敗');
          }
      }
  }
