<x-guest-layout>
    <div class="auth">
        <div class="auth__container">

            <img class='logo' src="images/logo.png" alt="logo Babyboom">


            <div class="auth__inner">
                <h1 class="auth__title">Welcome Back</h1>
                <p class="auth__subtitle">Log in to your account</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="auth__status" :status="session('status')" />

            <!-- Validation Errors -->
            <x-auth-validation-errors class="auth__error" :errors="$errors" />



            <form class="auth__form" method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-label  class="form__label--block" for="email" :value="__('Email')" />

                    <x-input style="background-image:url('{{ asset('images/envelope-fill.svg')}}')" class="form__input"  id="email"  type="email" name="email" :value="old('email')" required />
                </div>

                <!-- Password -->
                <div>
                    <x-label  class="form__label--block" for="password" :value="__('Password')" />

                    <x-input  style="background-image:url('{{ asset('images/lock-fill.svg')}}')" class="form__input" id="password"
                                    type="password"
                                    name="password"
                                    required autocomplete="current-password" />
                    <div>
                        @if (Route::has('password.request'))
                            <a class="auth__subtitle--bold right" href="{{ route('password.request') }}">
                                Forgot password?
                            </a>
                        @endif
                    </div>
                </div>



                {{-- <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div> --}}



                    <button type="submit" class="auth__submit">
                        {{ __('Log in') }}
                    </button>

            </form>
            <p class="auth__subtitle">Don't have an account?<a class="auth__subtitle--bold" href="{{route('register')}}"> Sign up</a></p>

            <img class="auth__illu" src="images/child.png" alt="illustration of a baby and a toy - babyboom">
        </div>
    </div>
</x-guest-layout>
