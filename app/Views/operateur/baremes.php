<?= $this->extend('operateur/layout') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3>📊 Barèmes — <?= esc($type['libelle'] ?? '') ?></h3>
        <a href="/operateur/types" class="btn btn-outline btn-sm">← Retour aux types</a>
    </div>
    <div class="card-body">
        <?php if (empty($baremes)): ?>
            <div class="empty-state">
                <div class="empty-icon">📊</div>
                <h4>Aucun barème défini</h4>
                <p>Ajoutez un barème ci-dessous.</p>
            </div>
        <?php else: ?>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Montant min (Ar)</th>
                            <th>Montant max (Ar)</th>
                            <th>Frais fixe (Ar)</th>
                            <th>Frais %</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($baremes as $b): ?>
                            <tr>
                                <form method="post" action="/operateur/baremes/modifier/<?= $b['id'] ?>">
                                    <td><input type="number" name="montant_min" value="<?= $b['montant_min'] ?>" class="form-control" style="width:120px" required></td>
                                    <td><input type="number" name="montant_max" value="<?= $b['montant_max'] ?>" class="form-control" style="width:120px" placeholder="Illimité"></td>
                                    <td><input type="number" name="frais_fixe" value="<?= $b['frais_fixe'] ?>" class="form-control" style="width:120px" required></td>
                                    <td><input type="number" name="frais_pourcentage" value="<?= $b['frais_pourcentage'] ?>" class="form-control" style="width:80px"></td>
                                    <td style="white-space:nowrap">
                                        <button type="submit" class="btn btn-success btn-sm">💾 Modifier</button>
                                    </td>
                                </form>
                                <td style="white-space:nowrap">
                                    <form method="post" action="/operateur/baremes/supprimer/<?= $b['id'] ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">🗑 Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <hr style="margin: 24px 0; border-color: var(--border);">

        <h4 style="margin-bottom: 16px;">Ajouter un barème</h4>
        <form method="post" action="/operateur/baremes/ajouter" class="form-row">
            <input type="hidden" name="type_operation_id" value="<?= $type['id'] ?>">
            <div class="form-group">
                <label>Montant min (Ar)</label>
                <input type="number" name="montant_min" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Montant max (Ar)</label>
                <input type="number" name="montant_max" class="form-control" placeholder="Illimité">
            </div>
            <div class="form-group">
                <label>Frais fixe (Ar)</label>
                <input type="number" name="frais_fixe" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Frais %</label>
                <input type="number" name="frais_pourcentage" class="form-control" value="0">
            </div>
            <div class="form-group" style="display:flex;align-items:flex-end;">
                <button type="submit" class="btn btn-primary">➕ Ajouter</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>