<?php

  namespace app\http\Requests;

  use Illuminate\Foundation\Http\FormRequest;

  class ReviewRegisterFormRequest extends FormRequest{
    public function authorize(){
        return true;  // ログイン制約が必要なら修正
    }

    public function rules(){
        return [
            'rating'       => ['required', 'integer'],
            'review_text'  => ['required', 'string'],
            'review_user_id'   => ['nullable', 'integer'], // 必須の場合は 'required'
            'review_house_id'  => ['nullable', 'integer'], // 必須の場合は 'required'
        ];
    }

    public function messages(){
        return [
            'rating.required'      => 'レーティングを入力してください。',
            'review_text.required' => 'レビューを入力してください。',
        ];
    }
  }
