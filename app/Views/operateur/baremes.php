<table border="1">
<tr><th>Min</th><th>Max</th><th>Frais fixe</th><th>Frais %</th><th></th></tr>
<?php foreach ($baremes as $b): ?>
<tr>
<form method="post" action="/operateur/baremes/modifier/<?= $b['id'] ?>">
<td><input type="number" name="montant_min" value="<?= $b['montant_min'] ?>" required></td>
<td><input type="number" name="montant_max" value="<?= $b['montant_max'] ?>" placeholder="Illimité"></td>
<td><input type="number" name="frais_fixe" value="<?= $b['frais_fixe'] ?>" required></td>
<td><input type="number" name="frais_pourcentage" value="<?= $b['frais_pourcentage'] ?>"></td>
<td>
    <button type="submit">Modifier</button>
</td>
</form>
<td>
<form method="post" action="/operateur/baremes/supprimer/<?= $b['id'] ?>">
<button type="submit">Supprimer</button>
</form>
</td>
</tr>
<?php endforeach; ?>
</table>