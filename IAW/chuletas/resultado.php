
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado</title>
</head>
<body>

    <h1>Resultado del número aleatorio</h1>

    <?php

    if (isset($_POST['minimo']) && isset($_POST['maximo'])) {

        $minimo = (int) $_POST['minimo'];
        $maximo = (int) $_POST['maximo'];

        if ($minimo <= $maximo) {

            $numero = random_int($minimo, $maximo);

            echo "<h2>El número generado es: $numero</h2>";

        } else {

            echo "<h2>Error: el mínimo no puede ser mayor que el máximo.</h2>";

        }

    } else {

        echo "No se han introducido los parámetros.";

    }

    ?>

    <br>

    <a href="index.php">
        <button>Volver</button>
    </a>

</body>
</html>
