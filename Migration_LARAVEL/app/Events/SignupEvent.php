<?php

  namespace app\Events;

  use app\Models\User;
  use Illuminate\Foundation\Events\Dispatchable;
  use Illuminate\Queue\SerializesModels;

  class SignupEvent{
    use Dispatchable, SerializesModels;

    public $user;
    public $requestUrl;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\User $user
     * @param string $requestUrl
     */
    public function __construct(User $user, string $requestUrl){
        $this->user = $user;
        $this->requestUrl = $requestUrl;
    }
  }
