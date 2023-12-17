@php /** @var \App\View\Components\Data\GridData $data */ @endphp

@if(!empty($data->filters))
    <form action="">
        <div class="container-fluid mt-3 mb-3">
            <div class="row">
                <div class="col">
                    <h4>Filters</h4>
                </div>
            </div>
            <div class="row">
                @php($hasActiveFilters = false)
                @foreach($data->filters as $filter)
                    @if($filter->isActive())
                        @php($hasActiveFilters = true)
                    @endif
                <div class="col">
                    <x-dynamic-component :component="$filter->getComponentName()" :filterData="$filter"/>
                </div>
                @endforeach

                <div class="col">
                    @if($hasActiveFilters)
                        <input type="reset" value="Reset" class="btn btn-secondary">
                    @endif

                    <input type="submit" value="Filter" class="btn btn-primary">
                </div>
            </div>
        </div>
    </form>
@endif
<table class="table table-hover table-striped">
    @if(!empty($data->headerColumns))
        <thead>
        <tr>
            @foreach($data->headerColumns as $column)
                <th>{{ $column }}</th>
            @endforeach
        </tr>
        </thead>
    @endif

    @if(!empty($data->rows))
        <tbody>
        @foreach($data->rows as $row)
            <tr>
                @foreach($row as $cell)
                    <td>{{ $cell }}</td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
    @endif
</table>
@if($data->links !== null)
    {{ $data->links }}
@endif
