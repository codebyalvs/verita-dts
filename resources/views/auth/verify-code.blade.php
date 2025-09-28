<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by entering the 6-digit code we just sent to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </div>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('verification.verify-code') }}">
            @csrf

            <div>
                <x-input-label for="code" :value="__('Verification Code')" />
                <x-text-input id="code" class="block mt-1 w-full" type="text" name="code" required autofocus />
                <x-input-error :messages="$errors->get('code')" class="mt-2" />
            </div>

            <div class="mt-4 flex items-center justify-between">
                <x-primary-button>
                    {{ __('Verify & Create Account') }}
                </x-primary-button>
            </div>
        </form>

        <div class="mt-4 flex items-center justify-start">
            <form method="POST" action="{{ route('verification.resend') }}">
                @csrf

                <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ __('Resend Verification Code') }}
                </button>
            </form>
        </div>
    </x-auth-card>
</x-guest-layout>
