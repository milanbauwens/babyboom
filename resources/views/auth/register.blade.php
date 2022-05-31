<x-guest-layout>
    <div class="auth">
        <div class="auth__container">

            <img class='logo' src="images/logo.png" alt="logo Babyboom">


            <div class="auth__inner">
                <h1 class="auth__title">{{ucfirst(__('join the family'))}}</h1>
                <p class="auth__subtitle">{{ucfirst(__('create a new account'))}}</p>
            </div>

            <!-- Validation Errors -->
            <x-auth-validation-errors class="auth__error" :errors="$errors" />

            <form class="auth__form" method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Firstname -->
                <div>
                    <label for="firstname" class="form__label--block">{{ucfirst(__('firstname'))}}</label>

                    <x-input style="background-image:url('{{ asset('images/person-fill.svg')}}')" id="firstname" class="form__input" type="text" name="firstname" :value="old('firstname')" required />
                </div>

                <!-- Lastname -->
                <div>
                    <label for="lastname" class="form__label--block">{{ucfirst(__('lastname'))}}</label>

                    <x-input style="background-image:url('{{ asset('images/person-fill.svg')}}')" id="lastname" class="form__input" type="text" name="lastname" :value="old('lastname')" required />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <label for="email" class="form__label--block">{{ucfirst(__('email'))}}</label>

                    <x-input style="background-image:url('{{ asset('images/envelope-fill.svg')}}')" id="email" class="form__input" type="email" name="email" :value="old('email')" required />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <label for="password" class="form__label--block">{{ucfirst(__('password'))}}</label>

                    <x-input  style="background-image:url('{{ asset('images/lock-fill.svg')}}')"  id="password" class="form__input"
                                    type="password"
                                    name="password"
                                    required />
                </div>


                <button type="submit" class="auth__submit">
                    {{ __("Register") }}
                </button>

            </form>
            <p class="auth__subtitle">{{ucfirst(__("already have an account?"))}}<a class="auth__subtitle--bold" href="{{route('login')}}"> {{ucfirst(__("Log in"))}}</a></p>
            <div class="margin"></div>
        </div>
    </div>
</x-guest-layout>
