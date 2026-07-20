<h2>Situation des comptes clients</h2>

<table border="1">
    <tr><th>Numéro</th><th>Solde</th><th>Dernière connexion</th></tr>
    <?php foreach ($clients as $c): ?>
    <tr>
        <td><?= esc($c['numero_telephone']) ?></td>
        <td><?= number_format($c['solde'], 2) ?> Ar</td>
        <td><?= $c['date_derniere_connexion'] ?? '—' ?></td>
    </tr>
    <?php endforeach; ?>
</table>