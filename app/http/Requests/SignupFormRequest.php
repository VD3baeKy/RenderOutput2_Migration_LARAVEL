<?php

  namespace app\http\Requests;

  use Illuminate\Foundation\Http\FormRequest;

  class SignupFormRequest extends FormRequest{
    public function authorize(){
        return true; // 必要なら認可ロジックを記述
    }

    public function rules(){
        return [
            'name'                  => ['required', 'string'],
            'furigana'              => ['required', 'string'],
            'postal_code'           => ['required', 'string'],
            'address'               => ['required', 'string'],
            'phone_number'          => ['required', 'string'],
            'email'                 => ['required', 'email'],
            'password'              => ['required', 'string', 'min:8', 'confirmed'], // confirmedで*_confirmationと一致必須
            // password_confirmationは自動的に required になります (confirmed指定時)
        ];
    }

    public function messages(){
        return [
            'name.required'                  => '氏名を入力してください。',
            'furigana.required'              => 'フリガナを入力してください。',
            'postal_code.required'           => '郵便番号を入力してください。',
            'address.required'               => '住所を入力してください。',
            'phone_number.required'          => '電話番号を入力してください。',
            'email.required'                 => 'メールアドレスを入力してください。',
            'email.email'                    => 'メールアドレスは正しい形式で入力してください。',
            'password.required'              => 'パスワードを入力してください。',
            'password.min'                   => 'パスワードは8文字以上で入力してください。',
            'password.confirmed'             => 'パスワード（確認用）と一致しません。',
            // password_confirmation の required メッセージも必要なら追加可能
            'password_confirmation.required' => 'パスワード（確認用）を入力してください。',
        ];
    }
  }
