<h2>Envoi multiple (même opérateur uniquement)</h2>
<?php if (session()->getFlashdata('error')): ?>
    <p style="color:red"><?= session()->getFlashdata('error') ?></p>
<?php endif; ?>
<form method="post" action="/client/transfert-multiple">
    <textarea name="numeros" placeholder="Numéros séparés par des virgules (ex: 0331234567,0337654321)" required></textarea>
    <input type="number" name="montant_total" placeholder="Montant total à répartir" required>
    <button type="submit">Envoyer</button>
</form>
<a href="/client/dashbord">Retour</a>