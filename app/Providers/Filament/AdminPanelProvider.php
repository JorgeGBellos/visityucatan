<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Width;
use Filament\View\PanelsRenderHook;
use Filament\Widgets\AccountWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->brandName('Visit Yucatán')
            ->brandLogo(asset('images/logotipos/horizontal.svg'))
            ->brandLogoHeight('1.75rem')
            ->favicon(asset('favicon.svg'))
            ->colors([
                'primary' => Color::hex('#6d8639'),
                'success' => Color::hex('#596e2f'),
                'warning' => Color::hex('#aac17b'),
                'danger' => Color::hex('#811C3F'),
                'gray' => Color::Stone,
            ])
            ->darkMode(false)
            ->maxContentWidth(Width::Full)
            ->sidebarCollapsibleOnDesktop()
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
            ])
            ->renderHook(
                PanelsRenderHook::HEAD_END,
                fn (): string => Blade::render('<style>
                    :root {
                        --vy-beige: #f0ebdd;
                        --vy-beige-soft: #f8f5ef;
                        --vy-black: #141112;
                        --vy-green: #6d8639;
                    }
                    .fi-body, .fi-simple-layout {
                        background-color: var(--vy-beige-soft) !important;
                    }
                    .fi-sidebar {
                        background-color: var(--vy-beige) !important;
                        border-right: 1px solid #eae5e3;
                    }
                    .fi-topbar {
                        background-color: #ffffff !important;
                        border-bottom: 1px solid #eae5e3;
                    }
                    .fi-simple-main {
                        background-color: transparent !important;
                    }
                    .fi-logo {
                        max-width: 11rem;
                    }
                    .fi-sidebar-header {
                        border-bottom: 1px solid #eae5e3;
                    }
                    .fi-btn-primary, .fi-ac-btn-action.fi-color-primary {
                        --tw-ring-color: var(--vy-green);
                    }
                </style>'),
            )
            ->renderHook(
                PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE,
                fn (): string => Blade::render('<div class="mb-6 text-center">
                    <p class="text-sm font-medium tracking-wide uppercase" style="color:#6d8639;letter-spacing:0.06em;">CMS · Visit Yucatán</p>
                    <p class="mt-1 text-sm" style="color:#444444;">Panel de administración del sitio</p>
                </div>'),
            )
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
