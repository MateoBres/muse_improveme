<html>
<head>
    <title>Indice dei corsi</title>
    <style>
        table {
            width: 100%;
        }

        table, th, td {
            border: 1px solid;
        }
    </style>
</head>
<body>
<h1>Pagina di indice dei corsi</h1>

<table>
    <thead>
    <tr>
        <th>#</th>
        <th>Titolo corso</th>
        <th>Descrizione corso</th>
        <th>Attivo</th>
        <th>Data di creazione</th>
        <th>Azioni</th>
    </tr>
    </thead>
    <tbody>
    @forelse($classes as $class)
    <tr>
        <td>{{ $class['id'] }}</td>
        <td>{{ $class['title'] }}</td>
        <td>{{ $class['description'] }}</td>
        <td>SI</td>
        <td>22/07/2022</td>
        <td>TODO</td>
    </tr>
    @empty
        <tr>
            <td colspan="6">Spiacenti! Nessun corso</td>
        </tr>
    @endforelse
    </tbody>
</table>
</body>
</html>
