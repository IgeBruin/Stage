@props(['name', 'label', 'type', 'value' => '', 'errors' => null])

<div class="form-group">
    <label for="{{ $name }}">{{ $label }}:</label>
    <input type="{{$type}}" class="form-control @if($errors->has($name)) is-invalid @endif" id="{{ $name }}" name="{{ $name }}" value="{{ old($name, $value) }}">
    @if ($errors->has($name))
        <div class="invalid-feedback">{{ $errors->first($name) }}</div>
    @endif
</div>
