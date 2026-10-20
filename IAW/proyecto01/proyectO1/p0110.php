<!DOCTYPE html>
<html lang="en">
    <?php var_export($_POST) ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
    $boton = $_POST['boton'];
    $sumatorio = 0;
    $producto = 1;
    $sumapares = 0;
    for ($i=1; $i <= $_POST['numero']; $i++)
        {
            echo $i," ";
            $sumatorio = $sumatorio + $i;
            $producto = $producto * $i;
            if ($i % 2 == 0) {
                $sumapares = $sumapares + $i;
            }
        }
    if ($boton==="sumatorio")
        {
           echo "El sumatorio es: ",$sumatorio;
        }

    else if ($boton==="producto")
        {
           echo "El producto es: ",$producto;
        }

    else if ($boton==="sumapares")
        {
           echo "La suma de pares es: ",$sumapares;
        }    
    ?>
</body>
</html>