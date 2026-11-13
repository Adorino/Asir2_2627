<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <?php
    /*

    for ($i=0; $i < 10; $i++)
        {
            echo "<p>ESTE ES MI PARRAFO " . $i . "</p>" ;
        }
        $aAlumnos = array ();
        $aAlumnos[0]="Dylan";
        $aAlumnos[1]="Ainara";
        $aAlumnos[2]="Gino";
        $aAlumnos[3]="Moha";
        $aAlumnos[4]="Dani";
        $aAlumnos[5]="Alvaro";
        $aAlumnos[6]="Adrian";
        echo "<ul>";
        foreach ($aAlumnos as $iAlumno)
            {
                echo "<li>.$iAlumno. </li>";
            }
        echo "</ul>";
    */
        
    for ($i=0; $i < 15; $i++)
  
    $talla1 = random_int(10, 50);
    $talla2 = random_int(10, 50);
    $talla3 = random_int(10, 50);
    $talla4 = random_int(10, 50);
    $talla5 = random_int(10, 50);
    $talla6 = random_int(10, 50);
    $talla7 = random_int(10, 50);
    $talla8 = random_int(10, 50);
    $talla9 = random_int(10, 50);
    $talla10 = random_int(10, 50);
    $talla11 = random_int(10, 50);
    $talla12 = random_int(10, 50);
    $talla13 = random_int(10, 50);
    $talla14 = random_int(10, 50);
    $talla15= random_int(10, 50);
   
        $aAlumnos = array ();
        $aAlumnos[0]=$talla1;
        $aAlumnos[1]=$talla2;
        $aAlumnos[2]=$talla3;
        $aAlumnos[3]=$talla4;
        $aAlumnos[4]=$talla5;
        $aAlumnos[5]=$talla6;
        $aAlumnos[6]=$talla7;
        $aAlumnos[7]=$talla8;
        $aAlumnos[8]=$talla9;
        $aAlumnos[9]=$talla10;
        $aAlumnos[10]=$talla11;
        $aAlumnos[11]=$talla12;
        $aAlumnos[12]=$talla13;
        $aAlumnos[13]=$talla14;
        $aAlumnos[14]=$talla15;
        $media = array_sum($aAlumnos) / count($aAlumnos);
        $tamanoMasGrande = max($aAlumnos);
        $tamanoMasPequeno = min($aAlumnos);

        echo "<ul>";
        foreach ($aAlumnos as $iAlumno)
            {
                echo "<li>Talla de zapato " . $iAlumno . "</li>";
            }
        echo "</ul>";
        echo "La media es " . $media . "<br>";
        echo "El tamaño más grande es " . $tamanoMasGrande . "<br>";
        echo "El tamaño más pequeño es " . $tamanoMasPequeno;

    ?>
    

// crear array numero de zapatos de 15 personas, calcular el zapato mayor, el meor y la media
</body>
</html>

