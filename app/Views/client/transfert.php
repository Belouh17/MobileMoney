<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Transfert</title></head>
<body>
    <h2>Transfert</h2>
    <p>Solde actuel : <?= $client['solde'] ?> Ar</p>

    <?php if (session()->getFlashdata('error')): ?>
        <p style="color:red;"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>

    <form method="post" action="/client/transfert">
        <input type="text" name="telephone_destinataire" placeholder="Numéro du destinataire" required>
        <input type="number" name="montant" step="0.01" min="1" placeholder="Montant" required>
        <button>Transférer</button>
    </form>

    <a href="/client/dashbord">Retour</a>
</body>
</html>