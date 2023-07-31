<select name="{{ $name }}" class="form-control">
    <option selected disabled>Select {{ ucfirst($name) }}...</option>
    @foreach ($options as $value => $label)
        <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>
            {{ $label }}
        </option>
    @endforeach
</select>
@error($name)
    <div class="alert alert-danger">{{ $message }}</div>
@enderror