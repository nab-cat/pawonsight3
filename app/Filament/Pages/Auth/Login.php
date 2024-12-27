<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Form;
use Filament\Pages\Auth\Login as AuthLogin;
use Filament\Forms\Components\TextInput;
use AbanoubNassem\FilamentGRecaptchaField\Forms\Components\GRecaptcha;
use Illuminate\Support\HtmlString;

class Login extends AuthLogin
{
    public ?string $email = null;
    public ?string $password = null;
    public ?string $captcha = null;
    public bool $remember = false;

    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        TextInput::make('email')
                            ->label('Email address')
                            ->email()
                            ->required()
                            ->autocomplete(),

                        TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->required(),

                        GRecaptcha::make('captcha')
                            ->key(config('services.recaptcha.site_key'))
                            ->required()
                            ->helperText('Mohon melakukan verifikasi reCAPTCHA untuk melindungi akun Anda.')
                    ])
            ),
        ];
    }
}