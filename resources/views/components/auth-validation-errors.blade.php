@props(['errors'])

@if ($errors->any())
    <div {{ $attributes }}>
        <div class="auth__error--text">
            {{ __('Whoops! Something went wrong.') }}
        </div>

        <div class="auth__error--list">
            @foreach ($errors->all() as $error)
                <p class="auth__error--item">{{ $error }}</p>
            @endforeach
        </div>
    </div>
@endif
