<h2>Types d'opérations</h2>

<form method="post" action="/operateur/types/ajouter">
    <input type="text" name="code" placeholder="ex: DEPOT" required>
    <input type="text" name="libelle" placeholder="ex: Dépôt" required>
    <button type="submit">Ajouter</button>
</form>

<ul>
<?php foreach ($types as $t): ?>
    <li>
        <?= esc($t['libelle']) ?>
        — <a href="/operateur/baremes/<?= $t['id'] ?>">Voir barèmes</a>
    </li>
<?php endforeach; ?>
</ul>