<?php

  namespace app\http\Requests;

  use Illuminate\Foundation\Http\FormRequest;

  class HouseEditFormRequest extends FormRequest{
    public function authorize(){
        return true; // 権限制御を行いたい場合はここにロジック記述
    }

    public function rules(){
        return [
            'id'             => ['required', 'integer'],
            'name'           => ['required', 'string'],
            'image_file'     => ['nullable', 'file', 'image', 'max:2048'], // 最大2MBなど
            'description'    => ['required', 'string'],
            'price'          => ['required', 'integer', 'min:1'],
            'capacity'       => ['required', 'integer', 'min:1'],
            'postal_code'    => ['required', 'string'],
            'address'        => ['required', 'string'],
            'phone_number'   => ['required', 'string'],
        ];
    }

    public function messages(){
        return [
            'name.required'         => '民宿名を入力してください。',
            'description.required'  => '説明を入力してください。',
            'price.required'        => '宿泊料金を入力してください。',
            'price.min'             => '宿泊料金は1円以上に設定してください。',
            'capacity.required'     => '定員を入力してください。',
            'capacity.min'          => '定員は1人以上に設定してください。',
            'postal_code.required'  => '郵便番号を入力してください。',
            'address.required'      => '住所を入力してください。',
            'phone_number.required' => '電話番号を入力してください。',
        ];
    }
  }
