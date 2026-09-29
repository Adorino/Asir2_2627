<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<h1>Adrian M es un tio de <?php  echo rand(0,10) ?></h1>
   <?php $numero1 = rand(1,200);
    $letra1 = "MOCO";
    $numero2 = 666;
    ?>
    
    <table border="ipx">
    <?php if ($numero1 == 15) echo "BINGO"; ?>
        <tr>
            <td><?php  echo $numero1  ?></td>
            <td><?php  echo $letra1 ?></td>
            <td><?php  echo $numero1  ?></td>
        </tr>
        <tr>
            <td><?php  echo $numero1 ?></td>
            <td><?php  echo $numero1?></td>
            <td><?php  echo $numero1 ?></td>
        </tr>
        <tr>
            <td><?php  echo $numero1 ?></td>
            <td><?php  echo $numero2 ?></td>
            <td><?php  echo $numero1 ?></td>
        </tr>
    </table>

    
</body>
</html>