<?php
$valores = ['A', 'K', 'Q', 'J', '10', '9', '8', '7', '6', '5', '4', '3', '2'];
$palos = ['P', 'C', 'T', 'D'];

$pesos = [
    'A' => 14, 'K' => 13, 'Q' => 12, 'J' => 11, '10' => 10,
    '9' => 9, '8' => 8, '7' => 7, '6' => 6, '5' => 5,
    '4' => 4, '3' => 3, '2' => 2
];


function generarMano($valores, $palos) {
    $mano = [];
    for ($i = 0; $i < 5; $i++) {
        $v = $valores[array_rand($valores)];
        $p = $palos[array_rand($palos)];
        $mano[] = ['valor' => $v, 'palo' => $p];
    }
    return $mano;
}

$mano1 = generarMano($valores, $palos);
$mano2 = generarMano($valores, $palos);

$compararCartas = function($a, $b) use ($pesos) {
    return $pesos[$b['valor']] <=> $pesos[$a['valor']];
};

$mano1_ordenada = $mano1;
$mano2_ordenada = $mano2;
usort($mano1_ordenada, $compararCartas);
usort($mano2_ordenada, $compararCartas);

$resultado = "";
$ganador = 0; // 0 = Empate, 1 = Jugador 1, 2 = Jugador 2

for ($i = 0; $i < 5; $i++) {
    $peso1 = $pesos[$mano1_ordenada[$i]['valor']];
    $peso2 = $pesos[$mano2_ordenada[$i]['valor']];
    
    $num_carta = $i + 1;
    $resultado .= "Comparando la carta alta n°{$num_carta}: Jugador 1 tiene '{$mano1_ordenada[$i]['valor']}' vs Jugador 2 tiene '{$mano2_ordenada[$i]['valor']}'.\n";
    
    if ($peso1 > $peso2) {
        $resultado .= "-> ¡Gana el Jugador 1 por tener la mejor carta alta ({$mano1_ordenada[$i]['valor']})!\n";
        $ganador = 1;
        break;
    } elseif ($peso2 > $peso1) {
        $resultado .= "-> ¡Gana el Jugador 2 por tener la mejor carta alta ({$mano2_ordenada[$i]['valor']})!\n";
        $ganador = 2;
        break;
    } else {
        $resultado .= "-> Empate en esta carta, se pasa a la siguiente.\n";
    }
}

if ($ganador == 0) {
    $resultado .= "\nResultado Final: ¡Empate absoluto! Ambas manos tienen exactamente los mismos valores de cartas.";
} else {
    $resultado .= "\nResultado Final: Gana el Jugador " . $ganador . ".";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado del Juego</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f0f2f5; text-align: center; padding: 20px; }
        .contenedor-manos { display: flex; justify-content: center; gap: 50px; margin-bottom: 30px; }
        .jugador { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); width: 400px; }
        .cartas { display: flex; justify-content: center; gap: 10px; margin-top: 15px; }
        .cartas img { width: 70px; height: auto; border-radius: 4px; border: 1px solid #ccc; }
        textarea { width: 80%; max-width: 700px; height: 180px; font-family: monospace; font-size: 14px; padding: 10px; border-radius: 5px; border: 1px solid #ccc; background-color: #fff; resize: none; }
        .btn-volver { display: inline-block; margin-top: 20px; padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; }
        .btn-volver:hover { background-color: #0056b3; }
    </style>
</head>
<body>
    <h1>Ronda de Póker</h1>

    <div class="contenedor-manos">
        <!-- Jugador 1 -->
        <div class="jugador">
            <h2>Jugador 1</h2>
            <div class="cartas">
                <?php foreach ($mano1 as $carta): ?>
                    <!-- Construcción dinámica de la URL de la imagen: Ej. A P -> AP.png -->
                    <img src="https://magicomagico.com/gilbertron/recursos/<?php echo $carta['valor'] . $carta['palo']; ?>.png" alt="<?php echo $carta['valor'] . $carta['palo']; ?>">
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Jugador 2 -->
        <div class="jugador">
            <h2>Jugador 2</h2>
            <div class="cartas">
                <?php foreach ($mano2 as $carta): ?>
                    <img src="https://magicomagico.com/gilbertron/recursos/<?php echo $carta['valor'] . $carta['palo']; ?>.png" alt="<?php echo $carta['valor'] . $carta['palo']; ?>">
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Historial y decisión en el Textarea -->
    <h3>Análisis de la Carta Más Alta</h3>
    <textarea readonly><?php echo htmlspecialchars($resultado); ?></textarea>

    <br>
    <a href="juego.php" class="btn-volver" style="background-color: #28a745;">Volver a jugar</a>
    <a href="index.php" class="btn-volver">Inicio</a>
</body>
</html>