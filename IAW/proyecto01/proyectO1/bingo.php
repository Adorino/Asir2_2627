<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<h1>Adrian M es un tio de <?php echo rand(0, 10); ?></h1>

<?php
$numero1 = rand(1, 200);
$letra1 = "MOCO";
$numero2 = 666;
$numero3 = rand(1, 200);
$numero4 = rand(1, 200);
$numero5 = rand(1, 200);
$numero6 = rand(1, 200);
$numero7 = rand(1, 200);
$numero8 = rand(1, 200);
$numero9 = rand(1, 200);
$numero10 = rand(1, 200);
$numero11 = rand(1, 200);
$numero12 = rand(1, 200);

if ($numero1 === 15) {
    $numero1 = "BINGO!";
}
if ($numero2 == 15) {
    $numero2 = "BINGO!";
}
if ($numero3 === 15) {
    $numero3 = "BINGO!";
}
if ($numero4 === 15) {
    $numero4 = "BINGO!";
}
if ($numero5 === 15) {
    $numero5 = "BINGO!";
}
if ($numero6 === 15) {
    $numero6 = "BINGO!";
}
if ($numero7 === 15) {
    $numero7 = "BINGO!";
}
if ($numero8 === 15) {
    $numero8 = "BINGO!";
}
if ($numero9 === 15) {
    $numero9 = "BINGO!";
}
if ($numero10 === 15) {
    $numero10 = "BINGO!";
}
if ($numero11 === 15) {
    $numero11 = "BINGO!";
}
if ($numero12 === 15) {
    $numero12 = "BINGO!";
}
?>

<table border="1">
    <?php if ($numero1 == 15) echo "BINGO"; ?>
    <tr>
        <td><?php echo $numero7; ?></td>
        <td><?php echo $letra1; ?></td>
        <td><?php echo $numero8; ?></td>
    </tr>
    <tr>
        <td><?php echo $numero9; ?></td>
        <td><?php echo $numero1; ?></td>
        <td><?php echo $numero10; ?></td>
    </tr>
    <tr>
        <td><?php echo $numero11; ?></td>
        <td><?php echo $numero2; ?></td>
        <td><?php echo $numero12; ?></td>
    </tr>
</table>

</body>
</html>