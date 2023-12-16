@php /** @var App\Data\Components\GridData $data */ @endphp

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
