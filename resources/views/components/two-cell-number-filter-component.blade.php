@php /** @var \App\View\Components\Data\TwoCellNumberFilterData $data */ @endphp

<div class="input-group input-group-sm mb-3">
    <span class="input-group-text" id="form-filter-{{ $data->leftCellName }}-{{ $data->rightCellName }}">{{ $data->label }}</span>

    <span class="input-group-text">{{ $data->leftCellLabel }}</span>
    <input
        type="number"
        class="form-control"
        name="{{ $data->leftCellName }}"
        value="{{ $data->leftCellValue }}"
        aria-label="{{ $data->label }}"
        aria-describedby="form-filter-{{ $data->leftCellName }}-{{ $data->rightCellName }}"
    >

    <span class="input-group-text">{{ $data->rightCellLabel }}</span>
    <input
        type="number"
        class="form-control"
        name="{{ $data->rightCellName }}"
        value="{{ $data->rightCellValue }}"
        aria-label="{{ $data->label }}"
        aria-describedby="form-filter-{{ $data->leftCellName }}-{{ $data->rightCellName }}"
    >
</div>
