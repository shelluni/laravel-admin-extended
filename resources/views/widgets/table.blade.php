<table {!! $attributes !!}>
    <thead>
    <tr>
        @foreach($headers as $header)
            <th>{{ $header }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($rows as $row)
        @if ($loop->first)
            <tr>
                @foreach($row as $item)
                    <td @if (array_key_exists($loop->index, $styles)) style=" {{ $styles[$loop->index] }} " @endif>{!! $item !!}</td>
                @endforeach
            </tr>
        @else
            <tr>
                @foreach($row as $item)
                    <td>{!! $item !!}</td>
                @endforeach
            </tr>
        @endif
    @endforeach
    </tbody>
</table>