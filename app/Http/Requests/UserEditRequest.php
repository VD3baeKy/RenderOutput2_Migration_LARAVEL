<?php

  namespace app\http\Requests;

  use Illuminate\Foundation\Http\FormRequest;

  class UserEditRequest extends FormRequest{
    /**
     * 認可ロジック（基本的に true でOK、必要に応じて変更）
     */
    public function authorize(){
        return true;
    }

    /**
     * バリデーションルール
     */
    public function rules(){
        return [
            'id' => 'required|integer',
            'name' => 'required|string',
            'furigana' => 'required|string',
            'postalCode' => 'required|string',
            'address' => 'required|string',
            'phoneNumber' => 'required|string',
            'email' => 'required|email',
        ];
    }

    /**
     * エラーメッセージ
     */
    public function messages(){
        return [
            'id.required' => 'IDは必須です。',
            'id.integer' => 'IDは整数で入力してください。',
            'name.required' => '氏名を入力してください。',
            'furigana.required' => 'フリガナを入力してください。',
            'postalCode.required' => '郵便番号を入力してください。',
            'address.required' => '住所を入力してください。',
            'phoneNumber.required' => '電話番号を入力してください。',
            'email.required' => 'メールアドレスを入力してください。',
            'email.email' => '有効なメールアドレス形式で入力してください。',
        ];
    }
  }
