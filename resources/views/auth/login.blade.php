<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-blue-600 px-4 py-8">
        <div class="w-full max-w-md mx-auto bg-blue-900 shadow-md rounded-lg p-6 text-white">
            <!-- Limité max-w-md para mantener un aspecto cuadrado -->

            <div class="flex justify-center mb-6">
                <img class="block h-16" src="{{ asset('/img/logo.webp') }}" alt="transporte multimodal">
            </div>

            <x-validation-errors class="mb-4" />

            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-300">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div>
                    <label for="email" class="block font-medium text-sm text-white">{{ __('Email') }}</label>
                    <x-input id="email" class="block mt-1 w-full p-3 bg-gray-800 text-white rounded" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                </div>

                <div class="mt-4">
                    <label for="password" class="block font-medium text-sm text-white">{{ __('Password') }}</label>
                    <x-input id="password" class="block mt-1 w-full p-3 bg-gray-800 text-white rounded" type="password" name="password" required autocomplete="current-password" />
                </div>

                <div class="block mt-4">
                    <label for="remember_me" class="flex items-center text-white">
                        <x-checkbox id="remember_me" name="remember" />
                        <span class="ml-2 text-sm">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="flex justify-center mt-6">
                    <x-button class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded w-full sm:w-auto text-center justify-center flex items-center">
                        {{ __('Log in') }}
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
