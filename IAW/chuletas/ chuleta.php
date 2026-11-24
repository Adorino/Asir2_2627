<?php

// Esto es un comentario de una línea.

/*
Esto es un comentario
de varias líneas.
*/

// Mostrar texto
echo "Hola mundo";
print "Hola mundo";

// Mostrar información de una variable
$variable = "Ejemplo";
var_dump($variable);
$array = ["Ejemplo"];
print_r($array);

// Finalizar una instrucción
echo "Hola";

?>

<?php

$nombre = "Carlos";        // Texto
$edad = 18;                // Número entero
$altura = 1.75;            // Decimal
$activo = true;            // Booleano
$vacio = null;             // Sin valor

// Modificar variables
$edad = 20;

// Concatenar
echo "Hola " . $nombre;

// Interpolar variables
echo "Me llamo $nombre";

// Constantes
define("PI", 3.1416);
const PAIS = "España";

// Comprobar si existe una variable
isset($nombre);

// Comprobar si está vacía
empty($nombre);

// Eliminar variable
unset($nombre);

?>

<?php

$a = 10;
$b = 3;

$suma = $a + $b;
$resta = $a - $b;
$multiplicacion = $a * $b;
$division = $a / $b;
$resto = $a % $b;
$potencia = $a ** $b;

// Incrementar y decrementar
$a++;
$b--;

?>

<?php

$a == $b;    // Igualdad de valor
$a === $b;   // Igualdad de valor y tipo
$a != $b;    // Diferente
$a !== $b;   // Diferente valor o tipo
$a > $b;     // Mayor
$a < $b;     // Menor
$a >= $b;    // Mayor o igual
$a <= $b;    // Menor o igual
$a <=> $b;   // Comparación combinada

?>

<?php

$a && $b;  // Y
$a || $b;  // O
!$a;       // NO
$a and $b;
$a or $b;
$a xor $b; // Uno u otro, pero no ambos

?>

<?php

$a && $b;  // Y
$a || $b;  // O
!$a;       // NO
$a and $b;
$a or $b;
$a xor $b; // Uno u otro, pero no ambos

?>

<?php

$edad = 18;

if ($edad >= 18) {

    echo "Eres mayor de edad";

} elseif ($edad >= 13) {

    echo "Eres adolescente";

} else {

    echo "Eres menor";

}

?>

<?php

$edad = 18;

if ($edad >= 18) {

    echo "Eres mayor de edad";

} elseif ($edad >= 13) {

    echo "Eres adolescente";

} else {

    echo "Eres menor";

}

?>

<?php

$numero = 2;

$resultado = match ($numero) {
    1 => "Uno",
    2 => "Dos",
    3 => "Tres",
    default => "Otro número"
};

echo $resultado;

?>

<?php

$i = 0;

while ($i < 10) {

    echo $i;
    $i++;

}

?>

<?php

$i = 0;

do {

    echo $i;
    $i++;

} while ($i < 10);

?>

<?php

$colores = ["Rojo", "Azul", "Verde"];

foreach ($colores as $color) {

    echo $color . "<br>";

}

// Con índice y valor
foreach ($colores as $indice => $color) {

    echo "$indice: $color";

}

?>

<?php

for ($i = 0; $i < 10; $i++) {

    if ($i == 5) {
        break; // Termina el bucle
    }

    if ($i == 2) {
        continue; // Salta esta vuelta
    }

    echo $i;

}

?>

<?php

$numeros = [1, 2, 3, 4, 5];

echo $numeros[0];

// Añadir elementos
$numeros[] = 6;

// Modificar
$numeros[0] = 10;

// Eliminar
unset($numeros[1]);

// Contar elementos
count($numeros);

?>

<?php

$persona = [
    "nombre" => "Ana",
    "edad" => 20,
    "ciudad" => "Madrid"
];

echo $persona["nombre"];

?>

<?php

function saludar() {
    echo "Hola";
}

saludar();

// Función con parámetros
function sumar($a, $b) {
    return $a + $b;
}

echo sumar(5, 3);

// Parámetros predeterminados
function bienvenida($nombre = "Invitado") {
    return "Hola " . $nombre;
}

echo bienvenida();

// Tipos de parámetros y retorno
function multiplicar(int $a, int $b): int {
    return $a * $b;
}

?>

<?php

// Función anónima
$saludo = function($nombre) {
    return "Hola " . $nombre;
};

echo $saludo("Ana");

// Función flecha
$doble = fn($numero) => $numero * 2;

echo $doble(5);

?>
