<h2>Situation des gains</h2>

<table border="1">
<tr><th>Réseau</th><th>Type d'opération</th><th>Total des frais</th></tr>
<?php foreach ($gains as $g): ?>
<tr>
<td><?= esc($g['reseau']) ?></td>
<td><?= esc($g['type_operation']) ?></td>
<td><?= number_format($g['total_frais'], 2) ?> Ar</td>
</tr>
<?php endforeach; ?>
</table>