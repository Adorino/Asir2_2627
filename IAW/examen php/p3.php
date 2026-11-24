
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <h1>PITUFO GUSTAVO</h1>
    <form action="p2.php" method="get">
    <h2>Tu nombre es<?php echo $_GET['nombre']; ?></h2>
    <h2>Tu/s apellido/s es/son <?php echo $_GET['apellido']; ?></h2>
</form>
<img width="656" height="558" alt="imagen.png" src="imagen.png" />
    <form action="p4.php" method="post">
        <h2>Tu edad es <?php echo $_POST['edad']; ?></h2>
        <h2>Tu numero de la suerte es <?php echo $_POST['numero']; ?></h2>
    <div><input type="submit" name="boton" value="CONTINUAR"></div>
    </form>
</body>
</html>