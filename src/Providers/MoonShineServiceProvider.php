<?php

declare(strict_types=1);

namespace Leeto\MoonShine\Providers;

use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use Laravel\Sanctum\SanctumServiceProvider;
use Leeto\MoonShine\Commands\InstallCommand;
use Leeto\MoonShine\Commands\ResourceCommand;
use Leeto\MoonShine\Commands\UserCommand;
use Leeto\MoonShine\Http\Middleware\ConfigureSanctum;
use Leeto\MoonShine\Models\MoonshineUser;
use Leeto\MoonShine\MoonShine;

final class MoonShineServiceProvider extends ServiceProvider
{
    protected array $commands = [
        InstallCommand::class,
        ResourceCommand::class,
        UserCommand::class,
    ];

    protected array $middlewareGroups = [
        'moonshine' => [
            ConfigureSanctum::class,
            EnsureFrontendRequestsAreStateful::class,
            'throttle:60,1',
            SubstituteBindings::class,
        ],
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->resolveAuth();

        $this->registerRouteMiddleware();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(MoonShine::path('/database/migrations'));
        $this->loadTranslationsFrom(MoonShine::path('/lang'), 'moonshine');
        $this->loadViewsFrom(MoonShine::path('/resources/views'), 'moonshine');

        $this->publishes([
            MoonShine::path('/config/moonshine.php') => config_path('moonshine.php'),
        ]);

        $this->mergeConfigFrom(
            MoonShine::path('/config/moonshine.php'),
            'moonshine'
        );

        $this->loadRoutesFrom(MoonShine::path('/routes/moonshine.php'));

        $this->publishes([
            MoonShine::path('/lang') => $this->app->langPath('vendor/moonshine'),
        ]);

        $this->publishes([
            MoonShine::path('/public') => public_path('vendor/moonshine'),
        ], ['moonshine-assets', 'laravel-assets']);

        $this->publishes([
            MoonShine::path('/stubs/MoonShineServiceProvider.stub') => app_path(
                'Providers/MoonShineServiceProvider.php'
            ),
        ], 'moonshine-provider');

        if ($this->app->runningInConsole()) {
            $this->commands($this->commands);
        }

        $this->app->register(SanctumServiceProvider::class);
    }

    protected function resolveAuth(): void
    {
        config()->set('auth.guards.moonshine', [
            'driver' => 'session',
            'provider' => 'moonshine',
        ]);

        config()->set('auth.providers.moonshine', [
            'driver' => 'eloquent',
            'model' => MoonshineUser::class,
        ]);
    }

    /**
     * Register the route middleware.
     *
     * @return void
     */
    protected function registerRouteMiddleware(): void
    {
        $this->middlewareGroups['moonshine'] = array_merge(
            $this->middlewareGroups['moonshine'],
            config('moonshine.middlewares', [])
        );

        foreach ($this->middlewareGroups as $key => $middleware) {
            app('router')->middlewareGroup($key, $middleware);
        }
    }
}
