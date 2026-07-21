<?= $this->extend('client/layout') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3>📥 Dépôt d'argent</h3>
    </div>
    <div class="card-body">
        <div class="stat-card" style="margin-bottom: 24px;">
            <div class="stat-icon green">💰</div>
            <div class="stat-info">
                <div class="stat-label">Solde actuel</div>
                <div class="stat-value"><?= number_format($client['solde'], 2) ?> Ar</div>
            </div>
        </div>

        <form method="post" action="/client/depot">
            <div class="form-group">
                <label>Montant à déposer (Ar)</label>
                <input type="number" name="montant" step="0.01" min="1" placeholder="Ex: 10000" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">📥 Déposer</button>
            <a href="/client/dashbord" class="btn btn-outline">← Retour</a>
        </form>
    </div>
</div>
<?= $this->endSection() ?>