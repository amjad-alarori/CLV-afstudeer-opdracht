<?php

namespace App\Http\Livewire\Auth;

use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Livewire\Component;

class Register extends Component
{
    /** @var string */
    public $name = '';

    /** @var string */
    public $email = '';

    /** @var string */
    public $password = '';

    /** @var string */
    public $passwordConfirmation = '';

    /** @var string */
    public $type = '';

    public function register()
    {
        $this->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:8', 'same:passwordConfirmation'],
            'type' => ['required'],
        ]);
     
        $user = User::create([
            'email' => $this->email,
            'name' => $this->name,
            'password' => Hash::make($this->password),
        ])->attachRole($this->type);

        event(new Registered($user));

        Auth::login($user, true);

    
        if(Auth::user()->hasRole('admin')) {
            return redirect()->intended(route('admin/home'));
        } elseif(Auth::user()->hasRole('marketer')){
            return redirect()->intended(route('marketer/home'));
        } elseif(Auth::user()->hasRole('cleint')){
            return redirect()->intended(route('cleint/home'));
     }

     return redirect()->intended(route('home'));
        }
        

    public function render()
    {
        return view('livewire.auth.register')->extends('layouts.auth');
    }
}
