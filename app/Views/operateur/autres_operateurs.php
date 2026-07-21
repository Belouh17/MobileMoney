<?= $this->extend('operateur/layout') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3>🏢 Autres opérateurs</h3>
        <span class="badge badge-info"><?= count($operateurs) ?> opérateur(s)</span>
    </div>
    <div class="card-body">
        <form method="post" action="/operateur/autres-operateurs/ajouter" class="form-row" style="margin-bottom: 20px;">
            <div class="form-group">
                <label>Nom de l'opérateur</label>
                <input type="text" name="nom" placeholder="ex: Orange Money" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Commission (%)</label>
                <input type="number" step="0.01" name="commission_pourcentage" placeholder="ex: 2.5" class="form-control">
            </div>
            <div class="form-group" style="display:flex;align-items:flex-end;">
                <button type="submit" class="btn btn-primary">➕ Ajouter</button>
            </div>
        </form>

        <?php if (empty($operateurs)): ?>
            <div class="empty-state">
                <div class="empty-icon">🏢</div>
                <h4>Aucun autre opérateur</h4>
                <p>Ajoutez un opérateur partenaire pour gérer les envois externes.</p>
            </div>
        <?php else: ?>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Commission %</th>
                            <th>Préfixes</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($operateurs as $o): ?>
                            <tr>
                                <td><strong><?= esc($o['nom']) ?></strong></td>
                                <td>
                                    <form method="post" action="/operateur/autres-operateurs/modifier/<?= $o['id'] ?>" class="form-inline">
                                        <input type="number" step="0.01" name="commission_pourcentage" value="<?= $o['commission_pourcentage'] ?>" class="form-control" style="width:100px">
                                        <button type="submit" class="btn btn-success btn-sm">💾</button>
                                    </form>
                                </td>
                                <td>
                                    <a href="/operateur/autres-operateurs/<?= $o['id'] ?>/prefixes" class="btn btn-info btn-sm">📞 Voir préfixes</a>
                                </td>
                                <td>
                                    <span class="badge badge-success">Actif</span>
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