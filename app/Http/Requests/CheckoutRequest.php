<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'carts' => 'required',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'phone.required' => 'Phone is required',
            'address.required' => 'Address is required',
            'carts.required' => 'carts is required',
        ];
    }
    public function withValidator($validator)
    {
        if (!is_null($this->get('carts'))){
            $validator->after(function ($validator){
                foreach ($this->get('carts') as $cart){
                    if ((!isset($cart["id"])&&is_null($cart["id"])) ||
                        ( !isset($cart["name"])&& is_null($cart["name"])) ||
                        (!isset($cart["price"])&&is_null($cart["price"]))||
                        (  !isset($cart["quantity"])&&is_null($cart["quantity"]))){
                        $validator->errors()->add('carts', 'System Error');
                    }else{
                        if ($cart["quantity"] < 1) {
                            $validator->errors()->add('carts', 'System Error');
                        }
                    }

                }
            });
        }
    }
}
