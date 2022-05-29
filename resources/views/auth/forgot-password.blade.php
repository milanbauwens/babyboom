<x-guest-layout>
    <div class="auth">
        <div class="auth__container">

            <img class='logo' src="images/logo.png" alt="logo Babyboom">

            <div class="auth__inner">
                <p class="auth__subtitle">
                    {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                </p>
            </div>


            <!-- Session Status -->
            <x-auth-session-status class="auth__status" :status="session('status')" />

            <!-- Validation Errors -->
            <x-auth-validation-errors class="auth__error" :errors="$errors" />


            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <label class='form__label--block' for="email">{{ucfirst(__('email'))}}</label>

                    <x-input style="background-image:url('{{ asset('images/envelope-fill.svg')}}')" id="email" class="form__input" type="email" name="email" :value="old('email')" required autofocus />
                </div>

                    <button type="submit" class="auth__submit">
                        {{ __("Reset Password") }}
                    </button>
            </form>
            <a href="{{route('login')}}" class="button__delete--blue">{{ucfirst(__("Cancel"))}}</a>
            <img class="auth__illu" src="images/child.png" alt="illustration of a baby and a toy - babyboom">
        </div>
    </div>
</x-guest-layout>
