<html>
<head>
    <title>Dettaglio del corso</title>
</head>
<body>
<h1>Pagina di dettaglio dei corsi</h1>

<p>{{ $class['id'] }}</p>
<p>{{ $class['title'] }}</p>
<p>{{ $class['description'] }}</p>
<p>{{ $class['active'] ? 'SI' : 'NO' }}</p>
</body>
</html>
