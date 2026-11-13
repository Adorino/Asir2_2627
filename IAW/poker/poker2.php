<?php
// Generamos una carta aleatoria
function carta() {
    $n = rand(2, 14);
    if ($n == 14) $v = "A";
    elseif ($n == 13) $v = "K";
    elseif ($n == 12) $v = "Q";
    elseif ($n == 11) $v = "J";
    else $v = $n;
    $p = rand(1, 4);
    if ($p == 1) $palo = "P";
    elseif ($p == 2) $palo = "C";
    elseif ($p == 3) $palo = "T";
    else $palo = "D";
    return (object)["valor" => $v, "palo" => $palo];
}
// Generamos las cinco cartas de cada jugador
function mano() {
    $m = new stdClass();
    $m->c1 = carta();
    $m->c2 = carta();
    $m->c3 = carta();
    $m->c4 = carta();
    $m->c5 = carta();
    return $m;
}
// Obtiene una carta de la mano usando su posición (de 1 a 5).
function obtenerCarta($m, $posicion) {
    $propiedad = "c" . $posicion;
    return $m->$propiedad;
}
// Convertimos las cartas en números para compararlas
function peso($v) {
    if ($v == "A") return 14;
    if ($v == "K") return 13;
    if ($v == "Q") return 12;
    if ($v == "J") return 11;
    return (int)$v;
}
// Generamos las manos
$mano1 = mano();
$mano2 = mano();
// Ordenamos las cartas de mayor a menor
function ordenar($m) {
    for ($i = 1; $i <= 5; $i++) {
        for ($j = $i + 1; $j <= 5; $j++) {
            $a = "c".$i;
            $b = "c".$j;
            if (peso($m->$a->valor) < peso($m->$b->valor)) {
                $aux = $m->$a;
                $m->$a = $m->$b;
                $m->$b = $aux;
            }
        }
    }
    return $m;
}
$mano1 = ordenar($mano1);
$mano2 = ordenar($mano2);
// Comparamos las cartas
$resultado = "";
$ganador = 0;
for ($i = 1; $i <= 5; $i++) {
    $a = $mano1->{"c".$i};
    $b = $mano2->{"c".$i};
    $peso1 = peso($a->valor);
    $peso2 = peso($b->valor);
    $resultado .= "Carta $i: Jugador 1 ($a->valor) - Jugador 2 ($b->valor)\n";
    if ($peso1 > $peso2) {
        $ganador = 1;
        $resultado .= "Gana el jugador 1.\n";
        break;
    }
    elseif ($peso2 > $peso1) {
        $ganador = 2;
        $resultado .= "Gana el jugador 2.\n";
        break;
    }
    else {
        $resultado .= "Empate, pasamos a la siguiente carta.\n";
    }
}
// Resultado final
if ($ganador == 0) {
    $resultado .= "\nEmpate.";
} else {
    $resultado .= "\nResultado final: Gana el jugador $ganador.";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado del Juego</title>
    <style>        
    body {font-family: Arial, sans-serif;background-color: #f0f2f5;text-align: center;padding: 20px;}
    .contenedor-manos {display: flex;justify-content: center;gap: 50px;margin-bottom: 30px;}
    .jugador {background: white;padding: 20px;border-radius: 8px;box-shadow: 0 4px 6px rgba(0,0,0,0.1);width: 400px;}
    .cartas {display: flex;justify-content: center;gap: 10px;margin-top: 15px;}
    .cartas img {width: 70px;height: auto;border-radius: 4px;border: 1px solid #ccc;}
    textarea {width: 80%;max-width: 700px;height: 180px;font-family: monospace;font-size: 14px;padding: 10px;border-radius: 5px;border: 1px solid #ccc;background-color: #fff;resize: none;}
    .btn-volver {display: inline-block;margin-top: 20px;padding: 10px 20px;background-color: #007bff;color: white;text-decoration: none;border-radius: 5px;}
    </style>
</head>
<body>
    <h1>Ronda de Póker</h1>
    <div class="contenedor-manos">
        <!-- JUGADOR 1 -->
        <div class="jugador">
            <h2>Jugador 1</h2>
            <div class="cartas">
                <?php
                // Repetimos cinco veces para mostrar sus cinco cartas.
                for ($i = 1; $i <= 5; $i++) {
                    $carta = obtenerCarta($mano1, $i);
                    $imagen = $carta->valor . $carta->palo;
                    echo "<img src='https://magicomagico.com/gilbertron/recursos/$imagen.png' alt='$imagen'>";
                }
                ?>
            </div>
        </div>
        <!-- JUGADOR 2 -->
        <div class="jugador">
            <h2>Jugador 2</h2>
            <div class="cartas">
                <?php
                // Repetimos cinco veces para mostrar sus cinco cartas.
                for ($i = 1; $i <= 5; $i++) {
                    $carta = obtenerCarta($mano2, $i);
                    $imagen = $carta->valor . $carta->palo;
                    echo "<img src='https://magicomagico.com/gilbertron/recursos/$imagen.png' alt='$imagen'>";
                }
                ?>
            </div>
        </div>
    </div>
    <!-- MOSTRAMOS EL RESULTADO DE LA COMPARACIÓN -->
    <h3>Carta más alta</h3>
    <textarea readonly><?php echo htmlspecialchars($resultado); ?></textarea>
    <br>
    <a href="juego.php" class="btn-volver" style="background-color: #28a745;">
        Volver a jugar
    </a>
    <a href="index.php" class="btn-volver">
        Inicio
    </a>
</body>
</html>