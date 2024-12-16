<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Auth\Register as AuthRegister;
use AbanoubNassem\FilamentGRecaptchaField\Forms\Components\GRecaptcha;
use Illuminate\Validation\Rules\Password;

class Register extends AuthRegister
{
    public ?string $name = null;
    public ?string $email = null;
    public ?string $password = null;
    public ?string $password_confirmation = null;
    public ?string $captcha = null;
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        TextInput::make('name')
                        ->label('Nama Lengkap')
                            ->required()
                            ->validationMessages([
                                'required' => 'Nama wajib diisi.',
                            ])
                            ->maxLength(255)
                            ->autofocus(),
                            
                        TextInput::make('email')
                            ->label('Alamat Email')
                            ->email()
                            ->required()
                            ->validationMessages([
                                'required' => 'Email wajib diisi.',
                                'unique' => 'Email sudah terdaftar.',
                            ])
                            ->maxLength(255)
                            ->unique('users'),
                            
                        TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->required()
                            ->rule(Password::default())
                            ->dehydrateStateUsing(fn ($state) => bcrypt($state)),
                            
                        TextInput::make('password_confirmation')
                            ->label('Konfirmasi Password')
                            ->password()
                            ->required()
                            ->same('password'),
                            
                        GRecaptcha::make('captcha')
                            ->key(config('services.recaptcha.site_key'))
                            ->required()
                            ->validationMessages([
                                'required' => 'Mohon melakukan verifikasi reCAPTCHA.',
                            ])
                            ->helperText('Mohon melakukan verifikasi reCAPTCHA untuk melindungi akun Anda.')
                            
                    ])
            ),
        ];
    }
}