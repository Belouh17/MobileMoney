<h2>Montants à envoyer par opérateur</h2>
<table border="1">
<tr><th>Opérateur</th><th>Montant total</th></tr>
<?php foreach ($montants as $m): ?>
<tr>
    <td><?= esc($m['autre_operateur']) ?></td>
    <td><?= number_format($m['montant_total_a_envoyer'], 2) ?> Ar</td>
</tr>
<?php endforeach; ?>
</table>