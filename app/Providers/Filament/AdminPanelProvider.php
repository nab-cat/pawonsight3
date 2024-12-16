<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\Forms\Form;
use Filament\PanelProvider;
use Filament\Navigation\MenuItem;
use Filament\Support\Colors\Color;
use App\Filament\Pages\Auth\Register;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use AbanoubNassem\FilamentGRecaptchaField\Forms\Components\GRecaptcha;
use AbanoubNassem\FilamentGRecaptchaField\FilamentGRecaptchaFieldPlugin;


class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->sidebarCollapsibleOnDesktop()
            ->default()
            ->spa()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->discoverClusters(in: app_path('Filament/Clusters'), for: 'App\\Filament\\Clusters')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->userMenuItems([
                MenuItem::make()
                    ->label('Pengaturan')
                    ->icon('heroicon-o-cog')
                    ->url('/admin/settings'),
                MenuItem::make()
                    ->label('Notifikasi')
                    ->icon('heroicon-o-bell')
                    ->url('/admin/notifications'),
                MenuItem::make()
                    ->label('Bantuan')
                    ->icon('heroicon-o-question-mark-circle')
                    ->url('https://www.instagram.com/alf.muhammad.ilyas'),
                MenuItem::make()
                    ->label('Halaman Utama')
                    ->icon('heroicon-o-home')
                    ->url('/'),
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                //Widgets\AccountWidget::class,
            ])
            ->databaseNotifications()
            ->brandLogo(asset('images/pawonsight.png'))
            ->favicon(asset('images/favicon.png'))
            ->brandLogoHeight('8.25rem')
            ->registration(Register::class)
            ->passwordReset()
            ->profile()
            ->font("DM Sans")
            ->emailVerification()
            ->unsavedChangesAlerts()
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}

