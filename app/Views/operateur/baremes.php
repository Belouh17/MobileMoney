<h2>Barèmes — <?= esc($type['libelle']) ?></h2>

<form method="post" action="/operateur/baremes/ajouter">
    <input type="hidden" name="type_operation_id" value="<?= $type['id'] ?>">
    <input type="number" name="montant_min" placeholder="Montant min" required>
    <input type="number" name="montant_max" placeholder="Montant max (vide = illimité)">
    <input type="number" name="frais_fixe" placeholder="Frais fixe" required>
    <input type="number" name="frais_pourcentage" placeholder="Frais % (optionnel)">
    <button type="submit">Ajouter</button>
</form>

<table border="1">
    <tr><th>Min</th><th>Max</th><th>Frais fixe</th><th>Frais %</th><th></th></tr>
    <?php foreach ($baremes as $b): ?>
    <tr>
        <td><?= $b['montant_min'] ?></td>
        <td><?= $b['montant_max'] ?? 'Illimité' ?></td>
        <td><?= $b['frais_fixe'] ?></td>
        <td><?= $b['frais_pourcentage'] ?></td>
        <td>
            <form method="post" action="/operateur/baremes/supprimer/<?= $b['id'] ?>">
                <button type="submit">Supprimer</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>