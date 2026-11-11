
@props(['label', 'name', 'type' => 'text', 'value' => ''])

<label for="{{ $name }}" class="form-label">{{ $label }}</label>

@if ($type === 'password')
    <div class="input-group">
        <input type="password"
            id="{{ $name }}"
            name="{{ $name }}"
            value="{{ old($name, $value) }}"
            autocomplete="{{ $attributes->get('autocomplete', 'current-password') }}"
            {{ $attributes->class(['form-control', 'is-invalid' => $errors->has($name)]) }}>

        <button class="btn btn-outline-secondary"
            type="button"
            onclick="togglePassword('{{ $name }}')"
            aria-label="Tampilkan kata sandi">
            <i class="bi bi-eye" id="icon-{{ $name }}"></i>
        </button>
    </div>
@else
    <input type="{{ $type }}"
        id="{{ $name }}"
        name="{{ $name }}"
        value="{{ old($name, $value) }}"
        {{ $attributes->class(['form-control', 'is-invalid' => $errors->has($name)]) }}>
@endif

@error($name)
    <div class="invalid-feedback">{{ $message }}</div>
@enderror

@if ($type === 'password')
    <script>
        function togglePassword(name) {
            const input = document.getElementById(name);
            const icon = document.getElementById('icon-' + name);

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('bi-eye', 'bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('bi-eye-slash', 'bi-eye');
            }
        }
    </script>
@endif
