<?php
  namespace app\Services;

  class StripeService{
    public function processSessionCompleted($event){
        // eventオブジェクトからデータを取得し、業務処理を記述
        // 例: $event->data->object->id など
    }
  }
