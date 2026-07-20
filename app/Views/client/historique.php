<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>
Historique
</h2>


<?php foreach($operations as $op): ?>

<p>

<?= $op->reference ?>

-
<?= $op->montant ?>

-
<?= $op->date_operation ?>

</p>


<?php endforeach; ?>
</body>
</html>