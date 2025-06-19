<?php
// app/Dto/ReviewDto.php
  namespace app\http\Requests;

  use Illuminate\Foundation\Http\FormRequest;

  class ReviewDto extends FormRequest{
    public function authorize()
    {
        return true;
    }

    // バリデーションルール
    public function rules()
    {
        return [
            'content' => 'required|string|max:1000',
            'rating'  => 'required|integer|min:1|max:5'
        ];
    }

    // ゲッターの代わりにこう使える
    public function getContent()
    {
        return $this->input('content');
    }
    public function getRating()
    {
        return $this->input('rating');
    }
  }
