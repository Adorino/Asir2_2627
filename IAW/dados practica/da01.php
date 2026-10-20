<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Juego de Dados - Selección</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container">
<h2>DADOS</h2>
<!-- se puede ver que es un formulario y enviará los datos a la pagina php de da02.php con el metodo de post -->
<form action="da02.php" method="POST">
        <!-- Aqui preguntará cuantos dados quieres -->
        <div class="form-group">
            <label for="dados">nº dados</label>
            <select name="dados" id="dados">
                <option value="1">1</option>
                <option value="2" selected>2</option>
                <option value="3">3</option>
            </select>
        </div>
<!-- aqui preguntará el numero de caras -->
        <div class="form-group">
            <label for="caras">nº caras</label>
            <select name="caras" id="caras">
                <option value="4" selected>4</option>
                <option value="6">6</option>
                <option value="8">8</option>
                <option value="10">10</option>
                <option value="12">12</option>
                <option value="20">20</option>
            </select>
        </div>
<!--- aqui se creó el valor de puntos de oponente -->
        <div class="form-group">
            <label for="oponente">Puntos Oponente</label>
            <input type="number" name="oponente" id="oponente" value="5" min="1" required>
        </div>

        <div class="btn-container">
            <button type="submit">¡Suerte!</button>
        </div>
    </form>
</div>

</body>
</html>

