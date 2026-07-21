<?= $this->extend('operateur/layout') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3>📈 Situation des gains</h3>
    </div>
    <div class="card-body">
        <?php if (empty($gains)): ?>
            <div class="empty-state">
                <div class="empty-icon">📈</div>
                <h4>Aucun gain enregistré</h4>
                <p>Les gains apparaîtront après les premières opérations.</p>
            </div>
        <?php else: ?>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Réseau</th>
                            <th>Type d'opération</th>
                            <th>Total des frais</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($gains as $g): ?>
                            <tr>
                                <td><?= esc($g['reseau'] ?? 'Notre réseau') ?></td>
                                <td><?= esc($g['type_operation']) ?></td>
                                <td><strong><?= number_format($g['total_frais'], 2) ?> Ar</strong></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>