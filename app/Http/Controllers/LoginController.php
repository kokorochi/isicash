<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddCartRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\NewUserRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Jobs\SendRegistrationJob;
use App\PasswordReset;
use App\User;
use App\UserAccount;
use App\UserAuth;
use App\UserVerifications;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\URL;
use View;

class LoginController extends Controller {

    public function login()
    {
        if (Auth::user())
        {
            $sessions['alert-warning'] = 'Anda sudah melakukan login dengan username ' . Auth::user()->username;
            View::share('sessions', $sessions);

            return redirect()->intended('/');
        }

        $data = [
            'username'        => '',
            'password'        => '',
            'password_retype' => '',
            'pin'             => '',
            'pin_retype'      => '',
            'email'           => '',
            'full_name'       => '',
            'phone'           => '',
            'dob'             => '',
            'sex'             => '',
        ];

        return view('user.login', compact('data'));
    }

    public function doLogin(LoginRequest $request)
    {
        $user = User::where('username', $request->username)->first();
        $user_account = $user->userAccount()->first();
        if (isset($user_account->verified) && $user_account->verified !== 1)
        {
            $request->session()->flash('alert-danger', 'User belum diverifikasi, harap cek email anda untuk melakukan verifikasi!');

            return redirect()->intended('/');
        }

        $attempt = Auth::attempt([
            'username' => $request->username,
            'password' => $request->password,
        ]);
        if ($attempt)
        {
            $user_account = Auth::user()->userAccount()->first();
            $user_account->last_login = Carbon::now()->toDateTimeString();
            $user_account->save();

            $request->session()->flash('alert-success', 'Anda telah berhasil login');

            if (! is_null(session('product_id')) && ! is_null(session('quantity')))
            {
                $cartController = new CartController();
                $cartRequest = new AddCartRequest();
                $cartRequest->product_id = session('product_id');
                $cartRequest->quantity = session('quantity');
                $cartController->addCart($cartRequest);
                session()->forget('product_id');
                session()->forget('quantity');
                session()->forget('url.intended');

                session([
                    'alert-success' => 'Produk berhasil ditambahkan ke keranjang',
                ]);

                return redirect('user/carts');
            }else{
                return redirect()->intended('/');
            }
        } else
        {
            $request->session()->flash('alert-danger', 'Username / Password anda salah!');

            return redirect()->intended('/');
        }
    }

    public function logout()
    {
        if (Auth::user()) Auth::logout();

        return redirect()->intended('/');
    }

    public function register()
    {
        if (Auth::user())
        {
            return redirect()->intended('/');
        }

        $data = [
            'username'        => '',
            'password'        => '',
            'password_retype' => '',
            'pin'             => '',
            'pin_retype'      => '',
            'email'           => '',
            'full_name'       => '',
            'phone'           => '',
            'dob'             => '',
            'sex'             => '',
        ];

        return view('user.register', compact('data'));
    }

    public function store(NewUserRequest $request)
    {
        $input = Input::all();
        $user = new User();
        $user->fill($input);
        $user->password = bcrypt($user->password);

        $user_account = new UserAccount();
        $user_account->fill($input);
        $user_account->pin = bcrypt($user_account->pin);
        $user_account->balance = 0;

        $user_auth = new UserAuth();
        $user_auth->auth_type = 'U'; //User

        $user_verification = new UserVerifications();
        $user_verification->username = $user->username;
        $user_verification->token = sha1(bcrypt($user->username));
        $user_verification->created_at = Carbon::now()->toDateTimeString();

        DB::transaction(function () use ($user, $user_account, $user_auth, $user_verification)
        {
            $user->save();

            $user->userAccount()->save($user_account);

            $user->userAuth()->save($user_auth);

            $user_verification->save();

            //Send Email
            $recipients = $user_account->email;
            $email['subject'] = '[ISICASH] Pendaftaran User Baru';
            $email['full_name'] = $user_account->full_name;
            $email['body_content'] = 'Kami mengucapkan terima kasih atas pendaftara user baru di <a href="' . URL::to('/') . '" target="_blank">www.isicash.com</a>.
            Sebelum anda mulai menggunakan isicash, pendaftar diharapkan untuk melakukan verifikasi terlebih dahulu melalui link berikut
            <a href="' . URL::to('user/verify?username=' . $user->username . '&token=' . $user_verification->token) . '" target="_blank">verifikasi isi cash</a>.';
            $email['footer'] = 'Terima kasih, dan selamat menggunakan.';

            dispatch(new SendRegistrationJob($recipients, $email));
        });

        $request->session()->flash('alert-success', 'Registrasi user baru telah berhasil dilakukan, silahkan cek email anda untuk verifikasi!');

        return redirect()->intended('/');
    }

    public function verifyUser(Request $request)
    {
        $input = Input::all();

        if (isset($input['username']) && isset($input['token']))
        {
            $user_verification = UserVerifications::where('username', $input['username'])->where('token', $input['token'])->first();
            if (! is_null($user_verification))
            {
                DB::transaction(function () use ($input, $user_verification, $request)
                {
                    $user = User::where('username', $input['username'])->first();
                    $user_account = $user->userAccount()->first();
                    $user_account->verified = 1;
                    $user_account->save();

                    $user_verification->where('username', $input['username'])->delete();
                });

                $request->session()->flash('alert-success', 'User telah berhasil diverifikasi, silahkan lakukan login!');

                return redirect()->intended('user/login');
            }
        }
        $request->session()->flash('alert-danger', 'User tidak ditemukan!');

        return redirect()->intended('user/login');
    }

    public function sendForgotPassword(ForgotPasswordRequest $request)
    {
        if (isset($request->username))
        {
            $user_account = User::where('username', $request->username)->first()->userAccount()->first();
        } else
        {
            $user_account = UserAccount::where('email', $request->email)->first();
        }

        DB::transaction(function () use ($user_account, $request)
        {
            $password_reset = PasswordReset::where('username', $request->username)->first();
            if (is_null($password_reset))
            {
                $password_reset = new PasswordReset();
                $password_reset->username = $user_account->user()->first()->username;
                $password_reset->token = sha1(bcrypt($password_reset->username));
                $password_reset->created_at = Carbon::now()->toDateTimeString();
                $password_reset->save();
            }

            //Send Email
            $recipients = $user_account->email;
            $email['subject'] = '[ISICASH] Permintaan Reset Password';
            $email['full_name'] = $user_account->full_name;
            $email['body_content'] = 'Berikut adalah link untuk melakukan reset password : <a href="' . URL::to('user/reset?username=' . $password_reset->username . '&token=' . $password_reset->token) . '" target="_blank">reset password</a>.
            Jika anda tidak mengenali atau tidak melakukan reset password, harap mengabaikan email ini.';
            $email['footer'] = 'Terima kasih';

            dispatch(new SendRegistrationJob($recipients, $email));
        });
        $request->session()->flash('alert-success', 'Email telah dikirim, silahkan cek email anda!');

        return redirect()->intended('user/login');
    }

    public function resetPassword()
    {
        if (Auth::user())
        {
            View::share('username', Auth::user()->username);

            return view('user.reset');
        } else
        {
            $input = Input::all();

            if (isset($input['username']) && isset($input['token']))
            {
                $password_reset = PasswordReset::where('username', $input['username'])->where('token', $input['token'])->first();
                if (! is_null($password_reset))
                {
                    View::share('username', $input['username']);

                    return view('user.reset');
                }
            }

            return redirect()->intended('/');
        }
    }

    public function doReset(ResetPasswordRequest $request)
    {
        $user = User::where('username', $request->username)->first();
        $user->password = bcrypt($request->password);
        $user->save();

        PasswordReset::where('username', $request->username)->delete();

        if (! Auth::user())
        {
            $request->session()->flash('alert-success', 'Password telah direset, silahkan login');

            return redirect()->intended('user/login');
        } else
        {
            return redirect()->intended('/');
        }
    }
}
