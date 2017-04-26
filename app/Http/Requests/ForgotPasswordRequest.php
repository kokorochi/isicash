<?php

namespace App\Http\Requests;

use App\User;
use App\UserAccount;
use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordRequest extends FormRequest {
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
        return [];
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

        if (is_null($this->input('username')) && is_null($this->input('email')))
        {
            $ret[] = 'Harap mengisi username atau email untuk melakukan reset password!';

            return $ret;
        }

        if (! is_null($this->input('username')))
        {
            $user = User::where('username', $this->input('username'))->first();
            if (is_null($user))
            {
                $ret[] = 'Username yang anda masukkan tidak ditemukan!';

                return $ret;
            }
        } else
        {
            $user_account = UserAccount::where('email', $this->input('email'))->first();
            if (is_null($user_account))
            {
                $ret[] = 'Tidak ada user dengan email yang anda masukkan!';

                return $ret;
            }
        }

        return $ret;
    }
}
