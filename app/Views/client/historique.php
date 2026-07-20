<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Historique</title></head>
<body>
    <h2>Historique</h2>

    <?php foreach ($operations as $op): ?>
        <p>
            <?= $op->reference ?> —
            <?= $op->montant ?> Ar
            (frais: <?= $op->frais ?> Ar) —
            <?= $op->date_operation ?> —
            <?= $op->statut ?>
        </p>
    <?php endforeach ?>

    <a href="/client/dashbord">Retour</a>
</body>
</html>