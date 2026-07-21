<?= $this->extend('client/layout') ?>

<?= $this->section('content') ?>
<div class="card">
    <div class="card-header">
        <h3>🔄 Transfert d'argent</h3>
    </div>
    <div class="card-body">
        <div class="stat-card" style="margin-bottom: 24px;">
            <div class="stat-icon green">💰</div>
            <div class="stat-info">
                <div class="stat-label">Solde actuel</div>
                <div class="stat-value"><?= number_format($client['solde'], 2) ?> Ar</div>
            </div>
        </div>

        <form method="post" action="/client/transfert">
            <div class="form-group">
                <label>Numéro du destinataire</label>
                <input type="text" name="telephone_destinataire" placeholder="Ex: 0331234567" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Montant (Ar)</label>
                <input type="number" name="montant" step="0.01" min="1" placeholder="Ex: 10000" class="form-control" required>
            </div>

            <div class="form-group">
                <label class="form-checkbox">
                    <input type="checkbox" name="option_frais_retrait" value="AVEC_FRAIS_RETRAIT">
                    Inclure les frais de retrait (le destinataire retire sans frais)
                </label>
                <p style="font-size: 12px; color: var(--text-muted); margin-top: 4px;">
                    Cette option ne s'applique qu'aux transferts vers notre réseau.
                </p>
            </div>
            <div class="form-groupe">
                <label for="">Epargne en pourcentage --
                    <input type="text" name="epargne" placeholder="xxx%">
                </label>
            </div>
            <button type="submit" class="btn btn-primary">🔄 Envoyer</button>
            <a href="/client/dashbord" class="btn btn-outline">← Retour</a>
        </form>
    </div>
</div>
<?= $this->endSection() ?>