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
    $numero3= rand(1,200);
    $numero4= rand(1,200);
    $numero5= rand(1,200);
    $numero6= rand(1,200);
    $numero7= rand(1,200);
    $numero8= rand(1,200);
    $numero9= rand(1,200);
    $numero10= rand(1,200);
    $numero11= rand(1,200);
    $numero12= rand(1,200);
    ?>
    
    <table border="ipx">
    <?php if ($numero1 == 15) echo "BINGO"; ?>
        <tr>
            <td><?php  echo $numero7  ?></td>
            <td><?php  echo $letra1 ?></td>
            <td><?php  echo $numero8  ?></td>
        </tr>
        <tr>
            <td><?php  echo $numero9 ?></td>
            <td><?php  echo $numero1?></td>
            <td><?php  echo $numero10 ?></td>
        </tr>
        <tr>
            <td><?php  echo $numero11 ?></td>
            <td><?php  echo $numero2 ?></td>
            <td><?php  echo $numero12 ?></td>
        </tr>
    </table>

    
</body>
</html>