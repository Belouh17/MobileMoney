<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Dépôt</title></head>
<body>
    <h2>Dépôt</h2>
    <p>Solde actuel : <?= $client['solde'] ?> Ar</p>

    <form method="post" action="/client/depot">
        <input type="number" name="montant" step="0.01" min="1" placeholder="Montant" required>
        <button>Déposer</button>
    </form>

    <a href="/client/dashbord">Retour</a>
</body>
</html>