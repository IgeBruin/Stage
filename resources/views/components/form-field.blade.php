@props(['name', 'label', 'value' => '', 'errors' => null])

<div class="form-group">
    <label for="{{ $name }}">{{ $label }}:</label>
    <input type="text" class="form-control @if($errors->has($name)) is-invalid @endif" id="{{ $name }}" name="{{ $name }}" value="{{ old($name, $value) }}">
    @if ($errors->has($name))
        <div class="invalid-feedback">{{ $errors->first($name) }}</div>
    @endif
</div>
