<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Transfert</title></head>
<body>
    <h2>Transfert d'argent</h2>
    <p>Solde actuel : <?= $client['solde'] ?> Ar</p>

    <?php if (session()->getFlashdata('error')): ?>
        <p style="color:red;"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>

    <form method="post" action="/client/transfert">
        <label>Numéro du destinataire :</label><br>
        <input type="text" name="telephone_destinataire" required><br><br>

        <label>Montant :</label><br>
        <input type="number" name="montant" step="0.01" min="1" required><br><br>

        <label>
            <input type="checkbox" name="option_frais_retrait" value="AVEC_FRAIS_RETRAIT">
            Inclure les frais de retrait (le destinataire retire sans frais)
        </label>
        <p><small>Cette option ne s'applique qu'aux transferts vers notre réseau ; elle est ignorée automatiquement pour les envois vers un autre opérateur.</small></p>
        <br>

        <button type="submit">Envoyer</button>
    </form>

    <a href="/client/dashbord">Retour</a>
</body>
</html>