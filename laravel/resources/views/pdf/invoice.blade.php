<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Aloha!</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <style type="text/css">
        * {
            font-family: "DejaVu Sans Mono", monospace;
        }
        table{
            font-size: x-small;
        }
        tfoot tr td{
            font-weight: bold;
            font-size: x-small;
        }
        .gray {
            background-color: lightgray
        }
    </style>

</head>
<body>

<table width="100%">
    <tr>
        <td>
            <pre>
                Company representative name
                Company address
                Tax ID
                phone
                fax
            </pre>
        </td>
        <td align="right">
            <h3>{{ $user->name }}</h3>
            <pre>
                Company representative name
                Company address
                Tax ID
                phone
                fax
            </pre>
        </td>
    </tr>

</table>

<table width="100%">
    <tr>
        <td><strong>From:</strong> {{ $user->name }} </td>
        <td><strong>To:</strong> {{ $principal->name }} </td>
    </tr>

</table>

<br/>

<table width="100%">
    <thead style="background-color: lightgray;">
    <tr>
        <th>#</th>
        <th>Opis</th>
        <th>Ilość</th>
        <th>Cena za godzinę Zł</th>
        <th>Suma Zł</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <th scope="row">1</th>
        <td>Usługi informatyczne</td>
        <td align="right">{{ $invoice->getRate() }}</td>
        <td align="right">{{ $invoice->getHours() }}</td>
        <td align="right">{{ $invoice->getFullAmount() }}</td>
    </tr>
    </tbody>

    <tfoot>
    <tr>
        <td colspan="3"></td>
        <td align="right">Suma Zł</td>
        <td align="right">{{ $invoice->getFullAmount() }}</td>
    </tr>
    </tfoot>
</table>

</body>
</html>
