@php /** @var \App\View\Components\Data\TextFilterData $data */ @endphp

<div class="input-group input-group-sm mb-3">
    <span class="input-group-text" id="form-filter-{{ $data->name }}">{{ $data->label }}</span>
    <input
        type="text"
        class="form-control"
        name="{{ $data->name }}"
        value="{{ $data->value }}"
        aria-label="{{ $data->label }}"
        aria-describedby="form-filter-{{ $data->name }}"
    >
</div>
