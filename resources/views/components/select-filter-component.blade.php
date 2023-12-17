@php /** @var \App\View\Components\Data\SelectFilterData $data */ @endphp

<div class="input-group input-group-sm mb-3">
    <span class="input-group-text" id="form-filter-{{ $data->name }}">{{ $data->label }}</span>

    <select class="form-select" aria-label="{{ $data->label }}" name="{{ $data->name }}">
        @foreach($data->values as $value)
            <option value="{{ $value->key }}" {{ $value->key == $data->selectedValue ? 'selected' : '' }}>{{ $value->value }}</option>
        @endforeach
    </select>
</div>
