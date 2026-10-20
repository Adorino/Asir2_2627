<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <?php
        $num1 = $_POST['num1'];
        $num2 = $_POST['num2'];

        if (isset($_POST['op'])) {
            $op = $_POST['op'];

            if ($op === '+') {
                  $suma = $num1 + $num2;
                echo $suma;
            }

            if ($op === '-') {
                       $resta = $num1 - $num2;
                echo $resta;
            }


            if ($op === '/') 
            {
                if ($op['$num2']=='0')
            {
                $sume= "no se puede dividir entre cero";
            }
            else
            {
                  $suma = $num1 / $num2;
                echo $suma;
            }
                }

            if ($op === '*') {
                  $suma = $num1 * $num2;
                echo $suma;
            }
        }
    ?>
</body>
</html>