<h2>Préfixes de l'opérateur</h2>

<form method="post" action="/operateur/prefixes/ajouter">
    <input type="text" name="prefixe" maxlength="3" placeholder="ex: 033" required>
    <button type="submit">Ajouter</button>
</form>

<ul>
<?php foreach ($prefixes as $p): ?>
    <li>
        <?= esc($p['prefixe']) ?>
        <form method="post" action="/operateur/prefixes/supprimer/<?= $p['id'] ?>" style="display:inline">
            <button type="submit">Supprimer</button>
        </form>
    </li>
<?php endforeach; ?>
</ul>