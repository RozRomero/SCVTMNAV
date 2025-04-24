<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-blue-600 px-4 py-8">
        <div class="w-full max-w-md sm:max-w-lg md:max-w-xl lg:max-w-2xl bg-blue-900 shadow-md rounded-lg p-6 text-white">
            
            <div class="flex justify-center mb-6">
                <x-authentication-card-logo />
            </div>

            <x-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div>
                    <label for="name" class="block font-medium text-sm text-white">{{ __('Name') }}</label>
                    <x-input id="name" class="block mt-1 w-full p-3 bg-gray-800 text-white rounded" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                </div>

                <div class="mt-4">
                    <label for="email" class="block font-medium text-sm text-white">{{ __('Email') }}</label>
                    <x-input id="email" class="block mt-1 w-full p-3 bg-gray-800 text-white rounded" type="email" name="email" :value="old('email')" required autocomplete="username" />
                </div>

                <div class="mt-4">
                    <label for="password" class="block font-medium text-sm text-white">{{ __('Password') }}</label>
                    <x-input id="password" class="block mt-1 w-full p-3 bg-gray-800 text-white rounded" type="password" name="password" required autocomplete="new-password" />
                </div>

                <div class="mt-4">
                    <label for="password_confirmation" class="block font-medium text-sm text-white">{{ __('Confirm Password') }}</label>
                    <x-input id="password_confirmation" class="block mt-1 w-full p-3 bg-gray-800 text-white rounded" type="password" name="password_confirmation" required autocomplete="new-password" />
                </div>

                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                    <div class="mt-4 text-white text-sm">
                        <label for="terms" class="flex items-start">
                            <x-checkbox name="terms" id="terms" required />
                            <span class="ml-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                    'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-indigo-300">'.__('Terms of Service').'</a>',
                                    'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-indigo-300">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </span>
                        </label>
                    </div>
                @endif

                <div class="flex flex-col sm:flex-row items-center justify-between mt-6 gap-4">
                    <a class="underline text-sm text-indigo-300 hover:text-white" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>

                    <x-button class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded w-full sm:w-auto text-center">
                        {{ __('Register') }}
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
