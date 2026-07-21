<?= $this->extend('operateur/layout') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3>👥 Situation des comptes clients</h3>
        <span class="badge badge-info"><?= count($clients) ?> client(s)</span>
    </div>
    <div class="card-body">
        <?php if (empty($clients)): ?>
            <div class="empty-state">
                <div class="empty-icon">👥</div>
                <h4>Aucun client enregistré</h4>
                <p>Les clients apparaîtront après les inscriptions.</p>
            </div>
        <?php else: ?>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Numéro</th>
                            <th>Solde</th>
                            <th>Date création</th>
                            <th>Dernière connexion</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($clients as $c): ?>
                            <tr>
                                <td><strong><?= esc($c['numero_telephone']) ?></strong></td>
                                <td><strong><?= number_format($c['solde'], 2) ?> Ar</strong></td>
                                <td><?= $c['date_creation'] ?? '—' ?></td>
                                <td><?= $c['date_derniere_connexion'] ?? '—' ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>