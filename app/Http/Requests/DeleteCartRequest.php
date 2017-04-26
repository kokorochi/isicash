<?php

namespace App\Http\Requests;

use App\ShoppingCart;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class DeleteCartRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    protected function getValidatorInstance()
    {
        return parent::getValidatorInstance()->after(function ($validator)
        {
            $this->after($validator);
        });
    }


    public function after($validator)
    {
        $check = $this->checkBeforeSave();
        if (count($check) > 0)
        {
            foreach ($check as $item)
            {
                $validator->errors()->add('alert-danger', $item);
            }
        }
    }

    private function checkBeforeSave()
    {
        $ret = [];

        $shopping_cart = ShoppingCart::find($this->input("id"));
        if(is_null($shopping_cart))
        {
            $ret[] = 'Item keranjang belanja tidak ditemukan';
            return $ret;
        }

        if($shopping_cart->username !== Auth::user()->username)
        {
            $ret[] = 'Anda tidak memiliki hak akses atas item tersebut';
            return $ret;
        }

        return $ret;
    }
}
