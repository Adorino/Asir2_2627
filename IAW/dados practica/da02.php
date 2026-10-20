<?php
// 1. RECOGER DATOS DEL FORMULARIO
$num_dados = (int)$_POST['dados'];
$num_caras = (int)$_POST['caras'];
$puntos_oponente = (int)$_POST['oponente'];
$forma_dado = "";
$mensaje = "";
$clase_mensaje = "";

// 2. AVERIGUAR LA FORMA DEL DADO CON "IF"
if ($num_caras == 4) {
    $forma_dado = "triangulo";
}
if ($num_caras == 6) {
    $forma_dado = "cuadrado";
}
if ($num_caras == 8) {
    $forma_dado = "octaedro";
}
if ($num_caras == 10) {
    $forma_dado = "decagono";
}
if ($num_caras == 12) {
    $forma_dado = "dodecaedro";
}
if ($num_caras == 20) {
    $forma_dado = "icosaedro";
}

// 3. LANZAR LOS DADOS UNO A UNO USANDO "IF"
$puntos_obtenidos = 0;
$valor_dado1 = 0;
$valor_dado2 = 0;
$valor_dado3 = 0;

if ($num_dados >= 1) {
    $valor_dado1 = rand(1, $num_caras);
    $puntos_obtenidos = $puntos_obtenidos + $valor_dado1;
}
if ($num_dados >= 2) {
    $valor_dado2 = rand(1, $num_caras);
    $puntos_obtenidos = $puntos_obtenidos + $valor_dado2;
}
if ($num_dados == 3) {
    $valor_dado3 = rand(1, $num_caras);
    $puntos_obtenidos = $puntos_obtenidos + $valor_dado3;
}

// 4. DETERMINAR SI GANAS O PIERDES CON "IF"
if ($puntos_obtenidos > $puntos_oponente) {
    $mensaje = "¡¡¡Ganaste!!!";
    $clase_mensaje = "ganas";
}
if ($puntos_obtenidos <= $puntos_oponente) {
    $mensaje = "¡Pierdes!!!";
    $clase_mensaje = "pierdes";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Juego de Dados - Resultado</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container">
    <h2>RESULTADO</h2>
    
    <div class="dados-container">
        <!-- MOSTRAR LOS DADOS USANDO "IF" EN LUGAR DE FOREACH -->
        <?php if ($num_dados >= 1): ?>
            <div class="dado-base <?php echo $forma_dado; ?>">
                <span><?php echo $valor_dado1; ?></span>
            </div>
        <?php endif; ?>

        <?php if ($num_dados >= 2): ?>
            <div class="dado-base <?php echo $forma_dado; ?>">
                <span><?php echo $valor_dado2; ?></span>
            </div>
        <?php endif; ?>

        <?php if ($num_dados == 3): ?>
            <div class="dado-base <?php echo $forma_dado; ?>">
                <span><?php echo $valor_dado3; ?></span>
            </div>
        <?php endif; ?>
    </div>

    <div class="resultado-puntos">
        <span>Puntos obtenidos</span>
        <div class="puntos-box"><?php echo $puntos_obtenidos; ?></div>
    </div>

    <div class="final-status <?php echo $clase_mensaje; ?>">
        <?php echo $mensaje; ?>
    </div>

    <a href="da01.php" class="back-link">← Volver a jugar</a>
</div>

</body>
</html>

