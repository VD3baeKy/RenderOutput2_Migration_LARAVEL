<?php

  namespace App\Http\Requests;

  use Illuminate\Foundation\Http\FormRequest;
  use Illuminate\Validation\Rule;
  use Illuminate\Support\Carbon;

  class ReservationInputFormRequest extends FormRequest{
    public function authorize(){
        return true;
    }

    public function rules(){
        return [
            // 「チェックイン日とチェックアウト日を選択してください。」
            'from_checkin_date_to_checkout_date' => ['required', 'string'],
            'number_of_people' => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages(){
        return [
            'from_checkin_date_to_checkout_date.required' => 'チェックイン日とチェックアウト日を選択してください。',
            'number_of_people.required' => '宿泊人数を入力してください。',
            'number_of_people.min' => '宿泊人数は1人以上に設定してください。',
        ];
    }

    // --- ↓ JavaのロジックをPHPで再現 ---
    /**
     * チェックイン日を取得
     * @return \Illuminate\Support\Carbon|null
     */
    public function getCheckinDate(){
        $arr = $this->splitCheckinCheckout();
        return isset($arr[0]) ? Carbon::parse($arr[0]) : null;
    }

    /**
     * チェックアウト日を取得
     * @return \Illuminate\Support\Carbon|null
     */
    public function getCheckoutDate(){
        $arr = $this->splitCheckinCheckout();
        return isset($arr[1]) ? Carbon::parse($arr[1]) : null;
    }

    /**
     * 入力値を「チェックイン日」と「チェックアウト日」に分解
     */
    protected function splitCheckinCheckout(){
        $str = $this->input('from_checkin_date_to_checkout_date');
        return $str ? preg_split('/ から /u', $str) : [null, null];
    }
  }
