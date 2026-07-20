<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Envoi multiple</title></head>
<body>
    <h2>Envoi multiple (même opérateur uniquement)</h2>
    <p>Solde actuel : <?= $client['solde'] ?> Ar</p>

    <?php if (session()->getFlashdata('error')): ?>
        <p style="color:red;"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>

    <form method="post" action="/client/transfert-multiple">
        <label>Numéros destinataires (séparés par des virgules) :</label><br>
        <textarea name="numeros" rows="3" placeholder="Ex: 0331234567,0337654321,0341234567" required></textarea><br>
        <input type="number" name="montant_total" step="0.01" min="1" placeholder="Montant total à répartir" required>
        <button type="submit">Envoyer</button>
    </form>

    <p><small>Le montant total est divisé à parts égales entre chaque numéro. Tous les numéros doivent appartenir à notre réseau.</small></p>

    <a href="/client/dashbord">Retour</a>
</body>
</html>