<h2>Autres opérateurs</h2>

<form method="post" action="/operateur/autres-operateurs/ajouter">
    <input type="text" name="nom" placeholder="Nom (ex: Telma)" required>
    <input type="number" step="0.01" name="commission_pourcentage" placeholder="Commission %">
    <button type="submit">Ajouter</button>
</form>

<table border="1">
<tr><th>Nom</th><th>Commission %</th><th></th></tr>
<?php foreach ($operateurs as $o): ?>
<tr>
    <td><?= esc($o['nom']) ?></td>
    <td>
        <form method="post" action="/operateur/autres-operateurs/modifier/<?= $o['id'] ?>" style="display:inline">
            <input type="number" step="0.01" name="commission_pourcentage" value="<?= $o['commission_pourcentage'] ?>">
            <button type="submit">MAJ</button>
        </form>
    </td>
    <td><a href="/operateur/autres-operateurs/<?= $o['id'] ?>/prefixes">Préfixes</a></td>
</tr>
<?php endforeach; ?>
</table>