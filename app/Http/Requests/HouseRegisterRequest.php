<?php

  namespace App\http\Requests;

  use Illuminate\Foundation\Http\FormRequest;

  class HouseRegisterRequest extends FormRequest{
    public function rules(){
        return [
	    'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|integer',
            'capacity' => 'required|integer',
            'postal_code' => 'required|string|max:10',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'imageFile' => 'nullable|image|max:2048',
      ];
    }
}
