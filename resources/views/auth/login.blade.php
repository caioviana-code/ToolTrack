<x-guest-layout>

    <style>
        .css-button {
            padding: 10px 20px;
            font-size: 16px;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            background-color: #247BA0;
            color: #fff;
        }

        .css-button:hover {
            background-color: #2980b9;
        }

        .css-titulo {
            font-size: 50px;
            color: #247BA0;
            font-weight: bold;
        }

        .css-fundo-titulo {
            background-color: #E2EEF3;
            
        }
    </style>

    <x-auth-card>

        <div class="css-fundo-titulo">
            <x-slot name="logo">
                <h1 class="css-titulo">ToolTrack</h1>
            </x-slot>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="login" :value="__('Login')" />

                <x-input id="login" class="block mt-1 w-full" type="text" name="login" :value="old('login')" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Senha')" />

                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <!-- Remember Me 
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>
-->
            <div class="flex items-center justify-end mt-4">
                <!--
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
-->
                <button class="ml-3 css-button">
                    {{ __('Entrar') }}
                </button>
            </div>

        </form>
    </x-auth-card>
</x-guest-layout>