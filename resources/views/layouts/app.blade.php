<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{}">
    <head>
        @include('moonshine::layouts.shared.head')

        <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
        <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
        <script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>

        @vite(['resources/js/app.js'], 'vendor/moonshine')

        {!! app(\Leeto\MoonShine\Utilities\AssetManager::class)->css() !!}

        @yield('after-styles')

        @stack('styles')

        {!! app(\Leeto\MoonShine\Utilities\AssetManager::class)->js() !!}

        @yield('after-scripts')

        <style>
            [x-cloak] { display: none !important; }
        </style>

        <script>
            const translates = @js(__('moonshine::ui'))
        </script>
    </head>
    <body x-cloak x-data="{ minimizedMenu: $persist(false).as('minimizedMenu'), asideMenuOpen: false }">
        <div class="layout-wrapper" :class="minimizedMenu && 'layout-wrapper-short'">
            @section('sidebar')
                @include('moonshine::layouts.shared.sidebar')
            @show

            <div class="layout-page">
                @include('moonshine::layouts.shared.flash')

                @section('header')
                    @include('moonshine::layouts.shared.header')
                @show

                <main class="layout-content">
                    @yield('content')
                </main>

                @section('footer')
                    @include('moonshine::layouts.shared.footer')
                @show
            </div>
        </div>


        @stack('scripts')
    </body>
</html>
