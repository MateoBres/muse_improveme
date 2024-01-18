<html>
<head>
    <title>Indice dei corsi</title>
</head>
<body>
<h1>Pagina per la creazione di un nuovo corso</h1>

<form action="{{ route('admin.classes.store') }}" method="POST">
    {{ csrf_field() }}

    <label for="title">Titolo</label>
    <input type="text" name="title" placeholder="Titolo">
    @error('title')
    <p style="color: red">{{ $message }}</p>
    @enderror

    <br>

    <label for="description">Descrizione</label>
    <textarea name="description" rows="5" placeholder="Descrizione"></textarea>
    @error('description')
    <p style="color: red">{{ $message }}</p>
    @enderror

    <br>

    <input type="checkbox" name="active" value="1"> Attivo
    @error('active')
    <p style="color: red">{{ $message }}</p>
    @enderror

    <button type="submit">Crea corso</button>
</form>
</body>
</html>
