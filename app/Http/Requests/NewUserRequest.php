<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewUserRequest extends FormRequest {
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
            'username'        => 'required|unique:users,username|max:30',
            'password'        => 'required',
            'password_retype' => 'required',
            'pin'             => 'required',
            'pin_retype'      => 'required',
            'email'           => 'required|unique:user_accounts,email',
            'full_name'       => 'required|max:191',
            'phone'           => 'required|max:30',
            'dob'             => 'required|date',
            'sex'             => 'required',
        ];
    }

    public function messages()
    {
        return [
            'username.required'        => 'Username harus diisi',
            'username.unique'          => 'Username tidak tersedia, silahkan pilih username yang lain',
            'password.required'        => 'Password harus diisi',
            'password_retype.required' => 'Password harus diisi',
            'pin.required'             => 'PIN harus diisi',
            'pin_retype.required'      => 'PIN harus diisi',
            'email.required'           => 'Email harus diisi',
            'email.unique'             => 'Email sudah ter-registrasi sebelumnya, mohon periksa kembali email anda',
            'full_name.required'       => 'Nama Lengkap harus diisi',
            'full_name.max'            => 'Maksimal 191 karakter',
            'phone.required'           => 'Nomor Hp harus diisi',
            'phone.max'                => 'Maksimal 30 karakter',
            'dob.required'             => 'Tanggal Lahir harus diisi',
            'sex.required'             => 'Jenis Kelamin harus diisi',
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
        if ($this->input('password') !== $this->input('password_retype'))
        {
            $ret[] = 'Password tidak sesuai, mohon ketik kembali password anda';
        }
        if($this->input('pin') !== $this->input('pin_retype'))
        {
            $ret[] = 'PIN tidak sesuai, mohon ketik kembali PIN anda';
        }
        if(! filter_var($this->input('email'), FILTER_VALIDATE_EMAIL))
        {
            $ret[] = 'Email yang anda masukkan tidak valid, mohon periksa kembali email anda';
        }
        if($this->input('sex') !== 'L' && $this->input('sex') !== 'P')
        {
            $ret[] = 'Jenis kelamin yang anda pilih tidak valid, mohon periksa kembali';
        }

        return $ret;
    }
}
