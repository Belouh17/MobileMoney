<?= $this->extend('client/layout') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3>📋 Historique des opérations</h3>
        <span class="badge badge-info"><?= count($operations) ?> opération(s)</span>
    </div>
    <div class="card-body">
        <?php if (empty($operations)): ?>
            <div class="empty-state">
                <div class="empty-icon">📋</div>
                <h4>Aucune opération</h4>
                <p>Votre historique est vide pour le moment.</p>
            </div>
        <?php else: ?>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Référence</th>
                            <th>Montant</th>
                            <th>Frais</th>
                            <th>Date</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($operations as $op): ?>
                            <tr>
                                <td><code><?= esc($op->reference) ?></code></td>
                                <td><strong><?= number_format($op->montant, 2) ?> Ar</strong></td>
                                <td><?= number_format($op->frais, 2) ?> Ar</td>
                                <td><?= $op->date_operation ?></td>
                                <td>
                                    <?php if ($op->statut === 'REUSSI'): ?>
                                        <span class="badge badge-success">✅ Réussi</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger">❌ Échoué</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>