<h2>Connexion opérateur</h2>

<?php if (session()->getFlashdata('erreur')): ?>
    <p style="color:red"><?= esc(session()->getFlashdata('erreur')) ?></p>
<?php endif; ?>

<form method="post" action="/login">
    <?= csrf_field() ?>
    <input type="text" name="username" placeholder="Identifiant" required>
    <input type="password" name="password" placeholder="Mot de passe" required>
    <button type="submit">Connexion</button>
</form>