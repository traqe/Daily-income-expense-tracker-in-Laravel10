<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>{{ $title }}</title>
    <style>
        h1, h2, h3, h4, h5, h6, p, table {
            font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif'
        }
        table {
            width: 100%
            text-align:center;
        }
        tr, td {
            padding: 8px;
        }
    </style>
</head>
<body>
    <h2 style="text-align: center; padding: 8px; background-color: #000080; color: white; border-radius: 8px;">{{ $title }}</h2>
    <p>Name: {{ $content[1]->name }}</p>
    <p>UserId: #{{ $content[1]->id }}</p>
    <p>Email: {{ $content[1]->email }}</p>
    <hr>
    <h4>Transactions</h4>
    <table>
        <thead>
            <th>#</th>
            <th>Income</th>
            <th>Expenses</th>
        </thead>
        <tbody>
            @foreach ($content[0] as $transaction)
            <tr>
                <td>{{ ($transaction->id - count($content[0])) + 1 }}</td>
                @if($transaction->type == "income")
                <td>
                    ${{ number_format($transaction->amount) }} - {{ $transaction->transaction_date }} - {{ $transaction->description }}
                @else
                <td>

                </td>
                @endif
                @if($transaction->type == "expense")
                <td>
                    ${{ number_format($transaction->amount) }} - {{ $transaction->transaction_date }} - {{ $transaction->description }}
                </td>
                @else
                <td>

                </td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
    <h4>Total Income: ${{ number_format($content[2]) }}</h4>
    <h4>Total Expenses: ${{ number_format($content[3]) }}</h4>
    <h3>Balance: ${{ number_format($content[2] - $content[3]) }}</h3>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
