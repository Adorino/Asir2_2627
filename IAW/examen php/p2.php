
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <h1>PITUFO GUSTAVO</h1>
    <form action="p3.php" method="post">
        <label>Tu nombre es <?php echo $_POST['nombre']; ?></label><div style="margin:10px"><input type="text" name="nombre"></div>
        <label>Tu/s apellido/s es/son <?php echo $_POST['apellidos']; ?></label><div style="margin:10px"><input type="text" name="apellidos"></div>
    <label>Introduce tu edad:</label><div style="margin:10px"><input type="number" name="edad"></div>
    <div><label for="numero">numero</label><input type="number" name="numero" id="numero" value="5" min="1" max="9" required></div>
    </div><div style="margin:10px"><input type="submit" name="boton" value="CONTINUAR"></div></form>
<
</body>
</html>