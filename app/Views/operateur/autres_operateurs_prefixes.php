<h2>Préfixes — <?= esc($operateur['nom']) ?></h2>

<form method="post" action="/operateur/autres-operateurs/prefixes/ajouter">
    <input type="hidden" name="autre_operateur_id" value="<?= $operateur['id'] ?>">
    <input type="text" name="prefixe" maxlength="3" placeholder="ex: 032" required>
    <button type="submit">Ajouter</button>
</form>

<ul>
<?php foreach ($prefixes as $p): ?>
<li>
    <?= esc($p['prefixe']) ?>
    <form method="post" action="/operateur/autres-operateurs/prefixes/supprimer/<?= $p['id'] ?>" style="display:inline">
        <button type="submit">Supprimer</button>
    </form>
</li>
<?php endforeach; ?>
</ul>