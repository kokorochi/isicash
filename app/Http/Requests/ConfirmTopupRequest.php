<?php

namespace App\Http\Requests;

use App\Order;
use App\User;
use Illuminate\Foundation\Http\FormRequest;

class ConfirmTopupRequest extends FormRequest
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

        if(is_null($this->input('id')))
        {
            $ret[] = 'Order tidak ditemukan';
            return $ret;
        }

        $order = Order::find($this->input('id'));
        if(is_null($order))
        {
            $ret[] = 'Order tidak ditemukan';
            return $ret;
        }

        $order_stat = $order->orderStat()->orderBy('item', 'desc')->first();
        if($order_stat->status !== 'WAIT CONFIRMATION')
        {
            $ret[] = 'Order ini tidak dalam status menunggu konfirmasi pembayaran. [CURRENT STATUS = ' . $order_stat->status . ']';
            return $ret;
        }

        $user = User::where('username', $order->username)->first();
        $user_account = $user->userAccount()->first();
        if($user_account->banned !== null)
        {
            $ret[] = 'User ini sudah dibanned oleh admin!';
            return $ret;
        }

        return $ret;
    }
}
