<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Two Factor Authentication') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Add additional security to your account using two factor authentication.') }}
        </p>
    </header>

    @if (! auth()->user()->two_factor_secret)
        <form method="POST" action="{{ url('/user/two-factor-authentication') }}">
            @csrf
            <x-primary-button>
                {{ __('Enable') }}
            </x-primary-button>
        </form>
    @else
        <div class="mt-4">
            {!! auth()->user()->twoFactorQrCodeSvg() !!}
        </div>

        <div class="mt-4">
            <h3 class="font-semibold">
                {{ __('Recovery Codes') }}
            </h3>

            <ul class="mt-2 text-sm text-gray-600">
                @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes), true) as $code)
                    <li>{{ $code }}</li>
                @endforeach
            </ul>
        </div>

        <form method="POST" action="{{ url('/user/two-factor-authentication') }}" class="mt-4">
            @csrf
            @method('DELETE')

            <x-danger-button>
                {{ __('Disable') }}
            </x-danger-button>
        </form>
    @endif
</section>