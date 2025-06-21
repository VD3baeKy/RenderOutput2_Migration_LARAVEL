<?php

  namespace app\Events;

  use app\Events\SignupEvent;
  use app\Models\User;

  class SignupEventPublisher{
    public function publishSignupEvent(User $user, string $requestUrl){
        // Laravel流イベントパブリッシュ
        event(new SignupEvent($user, $requestUrl));
        // もしくは
        // SignupEvent::dispatch($user, $requestUrl);
    }
  }
