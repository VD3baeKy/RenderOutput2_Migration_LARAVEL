<?php

  namespace app\http\Requests;

  use Illuminate\Foundation\Http\FormRequest;

  class ReviewEditFormRequest extends FormRequest{
    public function authorize(){
        return true; // 必要なら認可ロジックを記述
    }

    public function rules(){
        return [
            'id'          => ['required', 'integer'],
            'rating'      => ['required', 'integer'],
            'review_text' => ['required', 'string'],
            'image_file'  => ['nullable', 'file', 'image', 'max:2048'],
        ];
    }

    public function messages(){
        return [
            'rating.required'       => 'レーティングを入力してください。',
            'review_text.required'  => 'レビューを入力してください。',
        ];
    }
  }
