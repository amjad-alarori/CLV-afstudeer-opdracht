<?php

namespace App\Http\Livewire\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    /** @var string */
    public $email = '';

    /** @var string */
    public $password = '';

    /** @var bool */
    public $remember = false;

    protected $rules = [
        'email' => ['required', 'email'],
        'password' => ['required'],
    ];

    public function authenticate()
    {
        $this->validate();

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            $this->addError('email', trans('auth.failed'));

            return;
        }

        if(Auth::user()->hasRole('admin')) {
            return redirect()->intended(route('/admin/home'));
        } elseif(Auth::user()->hasRole('marketer')){
            return redirect()->intended(route('marketer/home'));
        } elseif(Auth::user()->hasRole('cleint')){
            return redirect()->intended(route('cleint/home'));
     }

        
    }

    public function render()
    {
        return view('livewire.auth.login')->extends('layouts.auth');
    }
}
