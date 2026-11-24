
<?php
session_start();

// Inicializar el bingo
if (isset($_POST['iniciar']) || !isset($_SESSION['numeros'])) {
    $_SESSION['numeros'] = range(1, 90);
    shuffle($_SESSION['numeros']);
    $_SESSION['salidos'] = [];
}

// Sacar un número
if (isset($_POST['sacar'])) {

    if (count($_SESSION['numeros']) > 0) {

        $numero = array_pop($_SESSION['numeros']);

        $_SESSION['salidos'][] = $numero;
    }
}

// Reiniciar el bingo
if (isset($_POST['reiniciar'])) {
    session_destroy();
    header("Location: bingoindex.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bingo</title>

    <style>
        body {
            font-family: Arial;
            text-align: center;
            background-color: #f0f0f0;
        }

        h1 {
            color: darkblue;
        }

        .numero {
            font-size: 80px;
            color: red;
            margin: 30px;
            font-weight: bold;
        }

        button {
            padding: 15px 25px;
            font-size: 18px;
            margin: 10px;
            cursor: pointer;
        }

        .historial {
            margin: 20px;
            font-size: 22px;
        }
    </style>

</head>

<body>

    <h1>¡BINGO!</h1>

    <h2>Números que han salido:</h2>

    <div class="historial">
        <?php
        if (count($_SESSION['salidos']) > 0) {
            echo implode(" - ", $_SESSION['salidos']);
        } else {
            echo "Todavía no ha salido ningún número.";
        }
        ?>
    </div>

    <h2>Quedan:
        <?php echo count($_SESSION['numeros']); ?>
        números
    </h2>

    <form method="POST">

        <button type="submit" name="sacar"
            <?php if (count($_SESSION['numeros']) == 0) echo "disabled"; ?>>
            SACAR NÚMERO
        </button>

        <button type="submit" name="reiniciar">
            REINICIAR BINGO
        </button>

    </form>

    <?php
    if (count($_SESSION['numeros']) == 0) {
        echo "<h2>¡Han salido todos los números!</h2>";
    }
    ?>

</body>
</html>
