@php use Illuminate\Support\Facades\URL; @endphp
@php /** @var \App\View\Components\Data\GridData $data */ @endphp

@if(!empty($data->filters))
    <form action="" method="GET">
        <div class="container-fluid px-5 pt-4">
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
                    <div class="col-auto">
                        <x-dynamic-component :component="$filter->getComponentName()" :filterData="$filter"/>
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col d-flex justify-content-center">
                    @if($hasActiveFilters)
                        <a href="{{ URL::route('home') }}" class="btn btn-secondary mx-3">Reset</a>
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
