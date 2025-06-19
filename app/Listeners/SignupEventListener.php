<?php

  namespace app\Listeners;

  use app\Events\SignupEvent;
  use app\Services\VerificationTokenService;
  use Illuminate\Support\Str;
  use Illuminate\Contracts\Queue\ShouldQueue;

  class SignupEventListener implements ShouldQueue{
    protected $verificationTokenService;

    public function __construct(VerificationTokenService $verificationTokenService){
        $this->verificationTokenService = $verificationTokenService;
    }

    public function handle(SignupEvent $event){
        $user = $event->user;
        $token = Str::uuid()->toString();

        // トークンをDB保存
        $this->verificationTokenService->create($user, $token);

        // メール送信
        $recipientAddress = $user->email;
        $subject = "メール認証";
        $confirmationUrl = $event->requestUrl . "/verify?token=" . $token;
        $message = "以下のリンクをクリックして会員登録を完了してください。\n{$confirmationUrl}";

        // Laravelでは Mailファサード/通知がおすすめ
        \Mail::raw($message, function($mail) use ($recipientAddress, $subject) {
            $mail->to($recipientAddress)
                ->subject($subject);
        });
    }
  }
