@props(['status'])

@if ($status)
    <div {{ $attributes }}>
        <div class="auth__error--list">
            @foreach ($status->all() as $status)
                <p class="auth__error--item">{{ $status }}</p>
            @endforeach
        </div>
    </div>
@endif
