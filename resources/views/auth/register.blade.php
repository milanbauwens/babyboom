<x-guest-layout>
    <div class="auth">
        <div class="auth__container">

            <img class='logo' src="images/logo.png" alt="logo Babyboom">


            <div class="auth__inner">
                <h1 class="auth__title">Join the family</h1>
                <p class="auth__subtitle">Create a new account</p>
            </div>

            <!-- Validation Errors -->
            <x-auth-validation-errors class="auth__error" :errors="$errors" />

            <form class="auth__form" method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Firstname -->
                <div>
                    <x-label for="firstname" class="form__label--block" :value="__('Firstname')" />

                    <x-input style="background-image:url('{{ asset('images/person-fill.svg')}}')" id="firstname" class="form__input" type="text" name="firstname" :value="old('firstname')" required />
                </div>

                <!-- Lastname -->
                <div>
                    <x-label for="lastname" class="form__label--block" :value="__('Lastname')" />

                    <x-input style="background-image:url('{{ asset('images/person-fill.svg')}}')" id="lastname" class="form__input" type="text" name="lastname" :value="old('lastname')" required />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <x-label for="email" class="form__label--block"  :value="__('Email')" />

                    <x-input style="background-image:url('{{ asset('images/envelope-fill.svg')}}')" id="email" class="form__input" type="email" name="email" :value="old('email')" required />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-label for="password" class="form__label--block"  :value="__('Password')" />

                    <x-input  style="background-image:url('{{ asset('images/lock-fill.svg')}}')"  id="password" class="form__input"
                                    type="password"
                                    name="password"
                                    required />
                </div>


                <button type="submit" class="auth__submit">
                    {{ __('Sign up') }}
                </button>

            </form>
            <p class="auth__subtitle">Already have an account?<a class="auth__subtitle--bold" href="{{route('login')}}"> Log in</a></p>
            <div class="margin"></div>
        </div>
    </div>
</x-guest-layout>
