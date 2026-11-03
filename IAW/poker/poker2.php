<?php 
$valores = ['A', 'K', 'Q', 'J', '10', '9', '8', '7', '6', '5', '4', '3', '2'];
$palos = ['P', 'C', 'T', 'D'];

$pesos = [
    'A' => 14, 'K' => 13, 'Q' => 12, 'J' => 11, '10' => 10,
    '9' => 9, '8' => 8, '7' => 7, '6' => 6, '5' => 5,
    '4' => 4, '3' => 3, '2' => 2
];


function GenerarMano ($valores, $palos) {
    $mano = []    
    for ($i = 0, $i < 5; $i++ ) {
        $v = $valores[array_rand($valores)];
        $p = $palos[array_rand($palos)]
        $mano[] = ['valor' => $v, 'palo' => $p];
    }
    return $mano[]
}

$mano1 = GenerarMano($valores, $palos);
$mano2 = GenerarMano($valores, $palos);

$Compararcartas = function($a, $b) use ($pesos) {
    return $pesos[$b['valor']] <=> $pesos[$a['valor']];
}