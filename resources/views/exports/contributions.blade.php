<table>
    <thead>
        <tr>
            <th rowspan="2">Fecha de aporte</th>
            <th rowspan="2">Estudiante</th>
            <th rowspan="2">Categoria</th>
            <th rowspan="2">Descripcion</th>
            <th rowspan="2">Monto en BS</th>
            <th rowspan="2">Periodo</th>
            <th style="padding:2.5px;" colspan="{{ $categoriesCount }}">Aporte</th>
        </tr>
        <tr>
            @foreach ($categories as $category)
                <th>{{ $category->description }}</th>
            @endforeach
        </tr>
        <tr>total</tr>
    </thead>
    <tbody>
        @foreach ($contributions as $contribution)
            <tr>
                <td>
                    {{ \Carbon\Carbon::createFromTimestamp(strtotime($contribution->contribution_date))->format('d-m-Y') }}
                </td>
                <td>{{ $contribution->student->name . ' ' . $contribution->student->last_name }}</td>
                <td>{{ $contribution->category->description }}</td>
                <td>{{ $contribution->description }}</td>
                <td>{{ $contribution->bs_amount }}</td>
                <td>{{ $contribution->period_affected }}</td>
                @foreach ($categories as $category)
                    @if ($category->description == $contribution->category->description)
                        <td>{{ $contribution->amount }}</td>
                    @else
                        <td></td>
                    @endif
                @endforeach
            </tr>
        @endforeach

    </tbody>
</table>
