<h2>Connexion opérateur</h2>

<?php if (session()->getFlashdata('erreur')): ?>
    <p style="color:red"><?= session()->getFlashdata('erreur') ?></p>
<?php endif; ?>

<form method="post" action="/operateur/auth">
    <input type="text" name="nom_utilisateur" placeholder="Identifiant" required>
    <input type="password" name="mot_de_passe" placeholder="Mot de passe" required>
    <button type="submit">Connexion</button>
</form>