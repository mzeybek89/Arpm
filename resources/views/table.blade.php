<!DOCTYPE html>
<html>
<head>
    <title>Week of Individuals</title>
</head>
<body>
    <h1>Cumulative Sum Table</h1>
    Data successfully written to Google Sheets => <a target="_blank" href="https://docs.google.com/spreadsheets/d/1LubOWizm86FwFXBzfQXkyc1W767n1UZMmnKQ_Ghfbms"><code>Link</code></a>
    <br><br>
    <table border="1">
        <thead>
            <tr>
                @foreach ($cumulativeTable[0] as $header)
                    <th>{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($cumulativeTable as $row)
                <tr>
                    @foreach ($row as $cell)
                        <td>                           
                            @if (is_numeric($cell))
                                {{ number_format($cell, 2) }}
                            @else
                                {{ $cell }} 
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>    
</body>
</html>








