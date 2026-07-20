<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Retrait</title></head>
<body>
    <h2>Retrait</h2>
    <p>Solde actuel : <?= $client['solde'] ?> Ar</p>

    <form method="post" action="/client/retrait">
        <input type="number" name="montant" step="0.01" min="1" placeholder="Montant" required>
        <button>Retirer</button>
    </form>

    <a href="/client/dashbord">Retour</a>
</body>
</html>