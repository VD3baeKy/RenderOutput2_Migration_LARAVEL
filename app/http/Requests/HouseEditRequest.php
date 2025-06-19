<?

  namespace App\Http\Requests;

  use Illuminate\Foundation\Http\FormRequest;

  class HouseEditRequest extends FormRequest{
    public function rules(){
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'capacity' => 'required|integer',
            'postal_code' => 'required|string|max:10',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            // 他のフィールドのバリデーションルール
        ];
    }
}
